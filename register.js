const firebaseConfig = {
    apiKey: "AIzaSyBtepkuXjYPSEIFuLTN-H0G88TYcq9y_s4",
    authDomain: "quick-quids.firebaseapp.com",
    projectId: "quick-quids",
    storageBucket: "quick-quids.firebasestorage.app",
    messagingSenderId: "848173248629",
    appId: "1:848173248629:web:b24f80c6b3045b8c8e483c",
    measurementId: "G-5S69PLV1VC"
};

firebase.initializeApp(firebaseConfig);
const auth = firebase.auth();
const db = firebase.firestore();
auth.setPersistence(firebase.auth.Auth.Persistence.SESSION);

const birthYearSelect = document.getElementById('birthYear');
for (let year = 1950; year <= 2024; year++) {
    const option = document.createElement('option');
    option.value = year;
    option.textContent = year;
    birthYearSelect.appendChild(option);
}

document.getElementById('registerForm').addEventListener('submit', (e) => {
    e.preventDefault();
    const fullName = document.getElementById('fullName').value;
    const mobile = document.getElementById('mobile').value;
    const email = document.getElementById('email').value;
    const birthYear = document.getElementById('birthYear').value;
    const gender = document.getElementById('gender').value;
    const password = document.getElementById('password').value;

    auth.createUserWithEmailAndPassword(email, password)
        .then((userCredential) => {
            const user = userCredential.user;
            return db.collection('users').doc(user.uid).set({
                fullName,
                mobileNumber: mobile,
                email,
                birthYear: Number(birthYear),
                gender,
                isBlocked: false
            });
        })
        .then(() => {
            const toast = document.getElementById('toast');
            toast.style.display = 'block';
            setTimeout(() => {
                toast.style.display = 'none';
                window.location.href = 'index.html';
            }, 1000);
        })
        .catch((error) => {
            alert('Registration failed: ' + error.message);
        });
});

document.getElementById('backBtn').addEventListener('click', () => {
    window.location.href = 'index.html';
});
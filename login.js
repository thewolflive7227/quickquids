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
auth.setPersistence(firebase.auth.Auth.Persistence.SESSION);

document.getElementById('loginForm').addEventListener('submit', (e) => {
    e.preventDefault();
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    auth.signInWithEmailAndPassword(email, password)
        .then((userCredential) => {
            const user = userCredential.user;
            user.getIdTokenResult().then((idTokenResult) => {
                if (idTokenResult.claims.admin) {
                    window.location.href = 'admin_panel.html';
                } else {
                    window.location.href = 'user_dashboard.html';
                }
            });
        })
        .catch((error) => {
            alert('Login failed: ' + error.message);
        });
});

document.getElementById('registerBtn').addEventListener('click', () => {
    window.location.href = 'register.html';
});
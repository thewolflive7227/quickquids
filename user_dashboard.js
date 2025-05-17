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
const rtdb = firebase.database();
auth.setPersistence(firebase.auth.Auth.Persistence.SESSION);

auth.onAuthStateChanged((user) => {
    if (!user) {
        window.location.href = 'index.html';
    } else {
        db.collection('users').doc(user.uid).get().then((doc) => {
            if (doc.exists && doc.data().isBlocked) {
                window.location.href = 'blocked.html';
            } else {
                document.getElementById('welcomeMsg').textContent = 
                    `WELCOME TO QUICK QUIDS MICRO FINANCE ${doc.data().fullName}`;
            }
        });
    }
});

function showLoanForm(loanType) {
    document.getElementById('loanForm').classList.remove('hidden');
    document.getElementById('loanApplicationForm').onsubmit = (e) => {
        e.preventDefault();
        const applicationData = {
            userId: auth.currentUser.uid,
            loanType,
            aadhaarNumber: document.getElementById('aadhaar').value,
            status: 'Under Process',
            createdAt: firebase.firestore.FieldValue.serverTimestamp()
        };
        db.collection('loanApplications').add(applicationData)
            .then(() => alert('Loan application submitted!'))
            .catch((error) => alert(error.message));
    };
}

document.getElementById('supportBtn').addEventListener('click', () => {
    document.getElementById('chatSection').classList.toggle('hidden');
    const chatRef = rtdb.ref(`supportChats/${auth.currentUser.uid}/messages`);
    chatRef.on('value', (snapshot) => {
        const messages = snapshot.val();
        document.getElementById('chatMessages').innerHTML = '';
        for (let msg in messages) {
            const p = document.createElement('p');
            p.textContent = `${messages[msg].sender}: ${messages[msg].message}`;
            document.getElementById('chatMessages').appendChild(p);
        }
    });
});

function sendMessage() {
    const message = document.getElementById('chatInput').value;
    rtdb.ref(`supportChats/${auth.currentUser.uid}/messages`).push({
        sender: 'user',
        message,
        timestamp: Date.now()
    });
    document.getElementById('chatInput').value = '';
}
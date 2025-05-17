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
        user.getIdTokenResult().then((idTokenResult) => {
            if (!idTokenResult.claims.admin) {
                window.location.href = 'user_dashboard.html';
            }
        });
    }
});

function showSection(sectionId) {
    document.querySelectorAll('.section').forEach(s => s.classList.add('hidden'));
    document.getElementById(sectionId).classList.remove('hidden');

    if (sectionId === 'users') {
        db.collection('users').get().then((snapshot) => {
            const userList = document.getElementById('userList');
            userList.innerHTML = '';
            snapshot.forEach(doc => {
                const data = doc.data();
                userList.innerHTML += `<p>${data.fullName} - <button onclick="toggleBlock('${doc.id}', ${data.isBlocked})">${data.isBlocked ? 'Unblock' : 'Block'}</button></p>`;
            });
        });
    } else if (sectionId === 'support') {
        rtdb.ref('supportChats').on('value', (snapshot) => {
            const supportList = document.getElementById('supportList');
            supportList.innerHTML = '';
            snapshot.forEach(child => {
                supportList.innerHTML += `<p>User ${child.key}: <button onclick="viewChat('${child.key}')">View Chat</button></p>`;
            });
        });
    }
}

function toggleBlock(userId, isBlocked) {
    db.collection('users').doc(userId).update({ isBlocked: !isBlocked });
}

function viewChat(userId) {
    const chatRef = rtdb.ref(`supportChats/${userId}/messages`);
    chatRef.on('value', (snapshot) => {
        alert(JSON.stringify(snapshot.val()));
    });
}
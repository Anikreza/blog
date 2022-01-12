const firebaseConfig = {
    apiKey: "AIzaSyBifDEX9gZz6ylQu8QcIN6RwQo9U9o9TkI",
    authDomain: "meraner-morgen.firebaseapp.com",
    projectId: "meraner-morgen",
    storageBucket: "meraner-morgen.appspot.com",
    messagingSenderId: "1096141852247",
    appId: "1:1096141852247:web:cd497b637c621535f15d12",
    measurementId: "G-S8PPE7HC3Z"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);
firebase.analytics();
const messaging = firebase.messaging();

function initFirebaseMessagingRegistration() {
    messaging
        .requestPermission()
        .then(function () {
            return messaging.getToken()
        })
        .then(function (token) {
            console.log(token); // @todo send request to save token in database
        }).catch(function (err) {
        console.log(err)
    });
}

initFirebaseMessagingRegistration()

messaging.onMessage(function (payload) {
    console.log(payload)
    const noteTitle = payload.notification.title;
    const noteOptions = {
        body: payload.notification.body,
        icon: payload.notification.image,
    };
    new Notification(noteTitle, noteOptions);
});

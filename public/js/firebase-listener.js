// firebase-listener.js
import { initializeApp } from "https://www.gstatic.com/firebasejs/11.0.1/firebase-app.js";
import { getFirestore, collection, onSnapshot } from "https://www.gstatic.com/firebasejs/11.0.1/firebase-firestore.js";

// Konfigurasi Firebase (ambil dari Firebase Console → Project settings)
const firebaseConfig = {
  apiKey: "API_KEY_KAMU",
  authDomain: "PROJECT_ID.firebaseapp.com",
  projectId: "PROJECT_ID",
  storageBucket: "PROJECT_ID.appspot.com",
  messagingSenderId: "xxxxxxx",
  appId: "1:xxxxxxx:web:xxxxxxx"
};

// Inisialisasi Firebase
const app = initializeApp(firebaseConfig);
const db = getFirestore(app);

// Realtime listener
onSnapshot(collection(db, "orders"), (snapshot) => {
  snapshot.docChanges().forEach((change) => {
    const order = change.doc.data();
    if (change.type === "added") {
      console.log("🟢 Pesanan baru:", order);
      alert(`Pesanan baru dari ${order.buyer_name}: ${order.menu_name}`);
      location.reload(); // Refresh otomatis agar dashboard seller update
    } else if (change.type === "modified") {
      console.log("🟡 Pesanan diupdate:", order);
      alert(`Status pesanan ${order.order_id} diubah menjadi ${order.status}`);
      location.reload();
    }
  });
});

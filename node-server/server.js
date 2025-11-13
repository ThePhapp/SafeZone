import express from "express";
import http from "http";
import { Server } from "socket.io";
import cors from "cors";

const app = express();
app.use(cors());
app.use(express.json());

const server = http.createServer(app);
const io = new Server(server, {
  cors: {
    origin: "*",
  },
});

// Kết nối client
io.on("connection", (socket) => {
  console.log("Client connected:", socket.id);
});

// Laravel sẽ gọi endpoint này sau khi thêm alert
app.post("/new-alert", (req, res) => {
  const alert = req.body;
  io.emit("alertCreated", alert); // Phát realtime cho tất cả client
  res.json({ status: "ok" });
});

const PORT = process.env.PORT || 6001;
server.listen(PORT, () => {
  console.log(`Realtime server chạy ở http://localhost:${PORT}`);
});

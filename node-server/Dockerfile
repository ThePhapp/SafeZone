# Sử dụng Node 20
FROM node:20

# Thư mục làm việc trong container
WORKDIR /usr/src/app

# Copy file package.json & package-lock.json
COPY package*.json ./

# Cài dependencies ở chế độ production
RUN npm install --production

# Copy toàn bộ mã nguồn vào container
COPY . .

# Mở cổng 6001 (server.js đang lắng nghe)
EXPOSE 6001

# Lệnh khởi động server
CMD ["node", "server.js"]

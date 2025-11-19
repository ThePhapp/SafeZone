# 🛡️ SafeZone - Disaster Alert & Management System

<details>
<summary><strong>🇻🇳 Tiếng Việt</strong></summary>

# 🛡️ SafeZone - Hệ Thống Cảnh Báo & Quản Lý Thiên Tai

SafeZone là nền tảng quản lý và cảnh báo thiên tai theo thời gian thực được xây dựng bằng Laravel, giúp cộng đồng nhận thông tin kịp thời và an toàn trong các tình huống khẩn cấp.

![SafeZone Banner](docs/images/banner-safezone.png)

## 📋 Mục Lục

- [Giới Thiệu](#giới-thiệu)
- [Lý Do Tạo Dự Án](#lý-do-tạo-dự-án)
- [Tính Năng Chính](#tính-năng-chính)
- [Ảnh Chụp Màn Hình](#ảnh-chụp-màn-hình)
- [Công Nghệ Sử Dụng](#công-nghệ-sử-dụng)
- [Bắt Đầu](#bắt-đầu)
- [Cài Đặt](#cài-đặt)
- [Cấu Trúc Dự Án](#cấu-trúc-dự-án)
- [Đóng Góp](#đóng-góp)
- [Giấy Phép](#giấy-phép)

## 🌟 Giới Thiệu

SafeZone là nền tảng cảnh báo thiên tai thời gian thực, cho phép cơ quan chức năng phát đi cảnh báo khẩn cấp và giúp người dân theo dõi thông tin về các thảm họa trong khu vực của họ. Hệ thống cung cấp bản đồ tương tác, thông báo tức thời và thông tin thiên tai toàn diện để đảm bảo an toàn công cộng.

## 🎯 Lý Do Tạo Dự Án

Việt Nam và nhiều quốc gia khác thường xuyên chịu ảnh hưởng của thiên tai (bão, lũ lụt, sạt lở đất, cháy rừng). Thông tin quan trọng thường bị phân mảnh trên nhiều kênh (báo chí, mạng xã hội, nhóm chat), bị trễ hoặc thiếu độ tin cậy. SafeZone được tạo ra để giải quyết các vấn đề cốt lõi sau:

- Tập trung cảnh báo thiên tai theo thời gian thực trên một nền tảng đáng tin cậy
- Giảm độ trễ thông tin giữa cơ quan quản lý và người dân
- Cung cấp trực quan hóa địa lý trực quan về vùng ảnh hưởng và khu vực an toàn
- Giúp mọi người quản lý nhiều địa điểm quan trọng (nhà, nơi làm việc, địa chỉ gia đình)
- Đề xuất các lựa chọn sơ tán bằng cách xác định nơi trú ẩn gần nhất
- Tăng cường khả năng chuẩn bị sớm với mô-đun dự đoán AI (tùy chọn)

Mục tiêu cuối cùng: Cải thiện tốc độ phản ứng của cộng đồng và giảm thiểu thiệt hại về người và tài sản thông qua một nền tảng đơn giản, minh bạch và có khả năng mở rộng.

## ✨ Tính Năng Chính

### 🗺️ Bản Đồ Tương Tác

- **Tích hợp MapLibre GL**: Trực quan hóa vùng thiên tai tương tác
- **Marker Tùy Chỉnh**: Biểu tượng theo loại (lũ lụt, hỏa hoạn, động đất, bão)
- **Vùng Động**: Vòng tròn bán kính nhấp nháy cho cảnh báo mới
- **Theo Dõi Vị Trí**: Hiển thị địa chỉ người dùng trên bản đồ
- **Cập Nhật Thời Gian Thực**: Cảnh báo mới xuất hiện ngay lập tức qua Socket.IO

![Interactive Map](docs/images/map-screenshot.png)

### 👤 Tính Năng Người Dùng

- **Bảng Điều Khiển Cá Nhân Hóa**: Trạng thái an toàn dựa trên vị trí người dùng
- **Quản Lý Nhiều Địa Chỉ**: Lưu và theo dõi nhiều vị trí
- **Lọc Cảnh Báo**: Lọc theo mức độ nghiêm trọng, loại, ngày và khoảng cách
- **Ba Chế Độ Xem**:
  - **Tất Cả Cảnh Báo**: Xem tất cả cảnh báo đang hoạt động
  - **Gần Bạn**: Cảnh báo trong phạm vi gần địa chỉ đã lưu
  - **Khu Vực Của Bạn**: Cảnh báo ảnh hưởng trực tiếp đến vị trí của bạn
- **Thông Tin Chi Tiết**: Hình ảnh, mô tả, bán kính ảnh hưởng và vị trí

![User Dashboard](docs/images/dashboard-screenshot.png)

### 🔔 Hệ Thống Thông Báo

- **Thông Báo Thời Gian Thực**: Cảnh báo tức thời được hỗ trợ bởi Socket.IO
- **Thông Báo Trong Ứng Dụng**: Trung tâm thông báo với trạng thái đã đọc/chưa đọc
- **Kênh Cơ Sở Dữ Liệu Tùy Chỉnh**: Lưu trữ thông báo bền vững
- **Phát Hiện Cảnh Báo Gần**: Thông báo tự động cho thiên tai gần đó

### 👨‍💼 Bảng Quản Trị

- **Thao Tác CRUD Đầy Đủ**: Quản lý cảnh báo, người dùng và cài đặt
- **Tải Lên Hình Ảnh**: Đính kèm ảnh chứng cứ thiên tai
- **Quản Lý Địa Chỉ**: Tích hợp geocoding cho vị trí chính xác
- **Quản Lý Vai Trò**: Vai trò quản trị viên và người dùng thông thường
- **Thống Kê Cảnh Báo**: Bảng điều khiển với các chỉ số chính

![Admin Panel](docs/images/admin-panel.png)

### 🌐 Tính Năng Thời Gian Thực

- **Cập Nhật Cảnh Báo Trực Tiếp**: Cảnh báo mới xuất hiện mà không cần tải lại trang
- **Tích Hợp Socket.IO**: Giao tiếp hai chiều theo thời gian thực
- **Phát Sự Kiện**: Hệ thống sự kiện Laravel với máy chủ Node.js

![Real-time Updates](docs/images/realtime-screenshot.png)

### 🏠 Nơi Trú Ẩn Gần Nhất

- **Tìm Nơi Trú Ẩn Gần Nhất**: Tự động tính toán nơi trú ẩn an toàn gần nhất với mỗi địa chỉ đã lưu
- **Tìm Kiếm Bán Kính Động**: Bán kính tìm kiếm có thể điều chỉnh (mặc định cấu hình qua `SHELTER_SEARCH_RADIUS_DEFAULT`)
- **Xếp Hạng Nhiều Kết Quả**: Nơi trú ẩn được xếp hạng theo khoảng cách và sức chứa
- **Truy Vấn Tối Ưu Hóa Địa Lý**: Sử dụng chỉ mục không gian / công thức Haversine
- **Cảnh Báo Phạm Vi**: Hiển thị cảnh báo nếu không có nơi trú ẩn trong phạm vi

![Shelter Finder](docs/images/shelter-finder.png)

### 🤖 Dự Đoán Thiên Tai AI

- **Gợi Ý Dự Báo**: Gợi ý cảnh báo sớm được hỗ trợ bởi AI trước khi có cảnh báo chính thức
- **Giải Thích Sinh Động**: Tóm tắt dễ hiểu về các yếu tố rủi ro (lượng mưa, gió, địa chấn)
- **Điểm Tin Cậy**: Mô hình trả về xác suất và mức độ nghiêm trọng
- **Cách Ly Mô Hình**: Dịch vụ dự đoán bên ngoài qua REST
- **Cờ Tính Năng Tùy Chọn**: Bật/tắt qua `PREDICTION_ENABLED=true|false`
- **Trừu Tượng Hóa Nhà Cung Cấp**: Hỗ trợ nhiều backend (Gemini / mô hình nội bộ)

![AI Prediction](docs/images/ai-prediction.png)

## 🛠️ Công Nghệ Sử Dụng

### Backend

- **Framework**: Laravel 11.x
- **Cơ Sở Dữ Liệu**: MySQL 8.0
- **PHP**: 8.2+
- **Xác Thực**: Laravel Breeze
- **ORM**: Eloquent
- **Thời Gian Thực**: Laravel Events + Socket.IO

### Frontend

- **UI Framework**: Tailwind CSS 3.x
- **JavaScript**: Alpine.js 3.x
- **Build Tool**: Vite 7.x
- **Bản Đồ**: MapLibre GL JS
- **Real-time Client**: Socket.IO Client 4.8.x
- **HTTP Client**: Axios

### Máy Chủ Thời Gian Thực

- **Runtime**: Node.js
- **Framework**: Express 5.x
- **WebSocket**: Socket.IO 4.8.x
- **CORS**: Được bật cho các yêu cầu cross-origin

### DevOps

- **Containerization**: Docker & Docker Compose
- **Web Server**: Nginx
- **Cache**: Redis (tùy chọn)
- **Version Control**: Git

## 🚀 Bắt Đầu

### Yêu Cầu

- PHP >= 8.2
- Composer
- Node.js >= 18.x
- npm hoặc yarn
- MySQL >= 8.0
- Docker & Docker Compose (tùy chọn)

### Cài Đặt

Xem hướng dẫn cài đặt đầy đủ tại: [docs/INSTALLATION.md](docs/INSTALLATION.md)

## 📁 Cấu Trúc Dự Án

```
SafeZoneVN/
├── SafeZone/              # Ứng dụng Laravel
│   ├── app/
│   │   ├── Http/Controllers/
│   │   ├── Models/
│   │   ├── Notifications/
│   │   └── Services/
│   ├── resources/
│   │   ├── views/         # Blade templates
│   │   └── js/           # Frontend assets
│   ├── routes/
│   ├── database/
│   └── public/
├── node-server/          # Máy chủ Socket.IO thời gian thực
│   ├── server.js
│   └── package.json
├── nginx/               # Cấu hình Nginx
├── mysql/               # Dữ liệu MySQL
└── docker-compose.yml   # Điều phối Docker
```

## 🤝 Đóng Góp

Chúng tôi hoan nghênh các đóng góp! Vui lòng làm theo các bước sau:

1. Fork repository
2. Tạo feature branch (`git checkout -b feature/TinhNangTuyetVoi`)
3. Commit các thay đổi (`git commit -m 'Thêm TinhNangTuyetVoi'`)
4. Push lên branch (`git push origin feature/TinhNangTuyetVoi`)
5. Mở Pull Request

## 📝 Giấy Phép

Dự án này được cấp phép theo Giấy phép MIT - xem file [LICENSE](LICENSE) để biết chi tiết.

## 👥 Tác Giả

- **Lê Đức Anh Tài** - _Công việc ban đầu_ - [leducanhtai](https://github.com/leducanhtai)

## 🙏 Lời Cảm Ơn

- Laravel Framework
- MapLibre GL JS
- Socket.IO
- Tailwind CSS
- Alpine.js
- Tất cả những người đóng góp và kiểm thử

## 📧 Liên Hệ

Để biết thêm thông tin hoặc hỗ trợ, vui lòng liên hệ:

- Email: taile13092k5@gmail.com
- GitHub: [@leducanhtai](https://github.com/leducanhtai)

---

Được tạo với ❤️ vì cộng đồng an toàn hơn

</details>

<details>
<summary><strong>🇯🇵 日本語</strong></summary>

# 🛡️ SafeZone - 災害警報・管理システム

SafeZone は、Laravel で構築された包括的な災害管理・警報システムで、自然災害や緊急事態の際に地域社会が情報を得て安全を保つことを支援するように設計されています。

![SafeZone Banner](docs/images/banner-safezone.png)

## 📋 目次

- [概要](#概要)
- [プロジェクトの目的](#プロジェクトの目的)
- [主な機能](#主な機能)
- [スクリーンショット](#スクリーンショット)
- [技術スタック](#技術スタック)
- [はじめに](#はじめに)
- [インストール](#インストール)
- [プロジェクト構成](#プロジェクト構成)
- [貢献](#貢献)
- [ライセンス](#ライセンス)

## 🌟 概要

SafeZone は、当局が緊急警報を放送し、ユーザーが自分の地域の災害に関する情報を入手できるようにするリアルタイム災害警報・管理プラットフォームです。このシステムは、インタラクティブマップ、リアルタイム通知、包括的な災害情報を提供し、公共の安全を確保します。

## 🎯 プロジェクトの目的

ベトナムや他の多くの国々では、自然災害（台風、洪水、地滑り、山火事）が頻繁に発生しています。重要な情報は、さまざまなチャネル（ニュースサイト、ソーシャルメディア、グループチャット）に分散し、遅延したり、信頼性に欠けたりすることがよくあります。SafeZone は、これらの中核的な問題を解決するために作成されました：

- 信頼できる単一のプラットフォームでリアルタイム災害警報を集中管理
- 当局と市民間の情報遅延を削減
- 影響範囲と安全エリアの直感的な地理空間視覚化を提供
- 複数の重要な場所（自宅、職場、家族の住所）の管理を支援
- 最寄りのシェルターを特定して避難オプションを提案
- オプションの AI 予測モジュールで早期準備を強化

最終目標：シンプルで透明性があり、スケーラブルなプラットフォームを通じて、コミュニティの対応速度を向上させ、人命と財産の損失を削減すること。

## ✨ 主な機能

### 🗺️ インタラクティブマップ

- **MapLibre GL 統合**：インタラクティブな災害ゾーン視覚化
- **カスタムマーカー**：タイプ別アイコン（洪水、火災、地震、嵐）
- **アニメーションゾーン**：新しい警報のための脈動する半径円
- **ユーザー位置追跡**：マップ上にユーザーアドレスを表示
- **リアルタイム更新**：Socket.IO 経由で新しい警報が即座に表示

![Interactive Map](docs/images/map-screenshot.png)

### 👤 ユーザー機能

- **パーソナライズドダッシュボード**：ユーザーの位置に基づく安全状態
- **複数アドレス管理**：複数の場所を保存・監視
- **警報フィルタリング**：重大度、タイプ、日付、距離でフィルタ
- **3 つの表示モード**：
  - **すべての警報**：すべてのアクティブな警報を表示
  - **近くの警報**：保存されたアドレスの近くの警報
  - **あなたのエリア内**：あなたの場所に直接影響する警報
- **詳細な警報情報**：画像、説明、影響半径、位置

![User Dashboard](docs/images/dashboard-screenshot.png)

### 🔔 通知システム

- **リアルタイム通知**：Socket.IO による即座の警報
- **アプリ内通知**：既読/未読ステータス付き通知センター
- **カスタムデータベースチャネル**：永続的な通知ストレージ
- **警報近接検出**：近くの災害の自動通知

### 👨‍💼 管理パネル

- **完全な CRUD 操作**：警報、ユーザー、設定の管理
- **画像アップロード**：災害証拠写真の添付
- **アドレス管理**：正確な位置のためのジオコーディング統合
- **ユーザーロール管理**：管理者と通常ユーザーのロール
- **警報統計**：主要メトリクスを含むダッシュボード

![Admin Panel](docs/images/admin-panel.png)

### 🌐 リアルタイム機能

- **ライブ警報更新**：ページを更新せずに新しい警報が表示
- **Socket.IO 統合**：双方向リアルタイム通信
- **イベントブロードキャスト**：Node.js サーバーを使用した Laravel イベントシステム

![Real-time Updates](docs/images/realtime-screenshot.png)

### 🏠 最寄りの避難シェルター

- **最寄りシェルター検索**：保存された各アドレスに対して最も近い安全なシェルターを自動計算
- **動的半径検索**：調整可能な検索半径（`SHELTER_SEARCH_RADIUS_DEFAULT`で設定可能）
- **複数結果ランキング**：距離と収容能力でシェルターをランク付け
- **地理最適化クエリ**：空間インデックス/ハバーサイン式を使用
- **ユーザーコンテキスト統合**：半径内にシェルターがない場合の警告表示

![Shelter Finder](docs/images/shelter-finder.png)

### 🤖 AI 災害予測

- **予測提案**：公式警報前の AI 支援早期警告ヒント
- **生成的説明**：リスク要因（降雨量、風、地震パターン）の人間が読める要約
- **信頼スコア**：モデルは確率と重大度バケット（低/中/高リスク）を返す
- **モデル分離**：REST 経由で消費される外部予測サービス（`PREDICTION_API_URL`/キー）
- **オプション機能フラグ**：`PREDICTION_ENABLED=true|false`で切り替え
- **プロバイダー抽象化**：複数のバックエンド（Gemini/内部モデルなど）をサポート

![AI Prediction](docs/images/ai-prediction.png)

## 🛠️ 技術スタック

### バックエンド

- **フレームワーク**：Laravel 11.x
- **データベース**：MySQL 8.0
- **PHP**：8.2+
- **認証**：Laravel Breeze
- **ORM**：Eloquent
- **リアルタイム**：Laravel Events + Socket.IO

### フロントエンド

- **UI フレームワーク**：Tailwind CSS 3.x
- **JavaScript**：Alpine.js 3.x
- **ビルドツール**：Vite 7.x
- **マップ**：MapLibre GL JS
- **リアルタイムクライアント**：Socket.IO Client 4.8.x
- **HTTP クライアント**：Axios

### リアルタイムサーバー

- **ランタイム**：Node.js
- **フレームワーク**：Express 5.x
- **WebSocket**：Socket.IO 4.8.x
- **CORS**：クロスオリジンリクエストに対応

### DevOps

- **コンテナ化**：Docker & Docker Compose
- **Web サーバー**：Nginx
- **キャッシュ**：Redis（オプション）
- **バージョン管理**：Git

## 🚀 はじめに

### 前提条件

- PHP >= 8.2
- Composer
- Node.js >= 18.x
- npm または yarn
- MySQL >= 8.0
- Docker & Docker Compose（オプション）

### インストール

完全なインストール手順については、[docs/INSTALLATION.md](docs/INSTALLATION.md)を参照してください。

## 📁 プロジェクト構成

```
SafeZoneVN/
├── SafeZone/              # Laravelアプリケーション
│   ├── app/
│   │   ├── Http/Controllers/
│   │   ├── Models/
│   │   ├── Notifications/
│   │   └── Services/
│   ├── resources/
│   │   ├── views/         # Bladeテンプレート
│   │   └── js/           # フロントエンドアセット
│   ├── routes/
│   ├── database/
│   └── public/
├── node-server/          # リアルタイムSocket.IOサーバー
│   ├── server.js
│   └── package.json
├── nginx/               # Nginx設定
├── mysql/               # MySQLデータ
└── docker-compose.yml   # Dockerオーケストレーション
```

## 🤝 貢献

貢献を歓迎します！以下の手順に従ってください：

1. リポジトリをフォーク
2. 機能ブランチを作成（`git checkout -b feature/素晴らしい機能`）
3. 変更をコミット（`git commit -m '素晴らしい機能を追加'`）
4. ブランチにプッシュ（`git push origin feature/素晴らしい機能`）
5. プルリクエストを開く

## 📝 ライセンス

このプロジェクトは MIT ライセンスの下でライセンスされています - 詳細については[LICENSE](LICENSE)ファイルを参照してください。

## 👥 著者

- **Lê Đức Anh Tài** - _初期作業_ - [leducanhtai](https://github.com/leducanhtai)

## 🙏 謝辞

- Laravel Framework
- MapLibre GL JS
- Socket.IO
- Tailwind CSS
- Alpine.js
- すべての貢献者とテスター

## 📧 連絡先

お問い合わせまたはサポートについては、以下までご連絡ください：

- Email: taile13092k5@gmail.com
- GitHub: [@leducanhtai](https://github.com/leducanhtai)

---

より安全なコミュニティのために ❤️ で作成

</details>
<details>
<summary><strong>🇺🇸 English</strong></summary>

SafeZone is a comprehensive disaster management and alert system built with Laravel, designed to help communities stay informed and safe during natural disasters and emergencies.

<!-- Add your logo/banner image here -->

![SafeZone Banner](docs/images/banner-safezone.png)

## 📋 Table of Contents

- [About](#about)
- [Key Features](#key-features)
- [Screenshots](#screenshots)
- [Technology Stack](#technology-stack)
- [Getting Started](#getting-started)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## 🌟 About

SafeZone is a real-time disaster alert and management platform that enables authorities to broadcast emergency alerts and helps users stay informed about disasters in their area. The system provides interactive maps, real-time notifications, and comprehensive disaster information to ensure public safety.

## 🎯 Project Motivation

Vietnam and many other countries experience frequent natural disasters (typhoons, floods, landslides, wildfires). Critical information is often fragmented across channels (news sites, social media, group chats), delayed, or unreliable. SafeZone was created to solve these core problems:

- Centralize real-time disaster alerts in one trusted platform
- Reduce information latency between authorities and citizens
- Provide intuitive geospatial visualization of impact zones and safe areas
- Help people manage multiple important locations (home, workplace, family addresses)
- Suggest evacuation options by identifying the nearest shelters
- Enhance early preparedness with an optional AI prediction module

Ultimate goal: Improve community response speed and reduce loss of life and property through a platform that is simple, transparent, and scalable.

## ✨ Key Features

### 🗺️ Interactive Maps

- **MapLibre GL Integration**: Interactive disaster zone visualization
- **Custom Markers**: Type-specific icons (flood, fire, earthquake, storm)
- **Animated Zones**: Pulsing radius circles for new alerts
- **User Location Tracking**: Display user addresses on the map
- **Real-time Updates**: New alerts appear on map instantly via Socket.IO

<!-- Add map interface screenshot here -->

![Interactive Map](docs/images/map-screenshot.png)

### 👤 User Features

- **Personalized Dashboard**: Safety status based on user location
- **Multiple Address Management**: Save and monitor multiple locations
- **Alert Filtering**: Filter by severity, type, date, and distance
- **Three View Modes**:
  - **All Alerts**: View all active alerts
  - **Near You**: Alerts within proximity to saved addresses
  - **In Your Area**: Alerts directly affecting your locations
- **Detailed Alert Information**: Images, descriptions, affected radius, and location

<!-- Add user dashboard screenshot here -->

![User Dashboard](docs/images/dashboard-screenshot.png)

### 🔔 Notification System

- **Real-time Notifications**: Socket.IO powered instant alerts
- **In-app Notifications**: Notification center with read/unread status
- **Custom Database Channels**: Persistent notification storage
- **Alert Proximity Detection**: Automatic notifications for nearby disasters

### 👨‍💼 Admin Panel

- **Complete CRUD Operations**: Manage alerts, users, and settings
- **Image Upload**: Attach disaster evidence photos
- **Address Management**: Geocoding integration for precise locations
- **User Role Management**: Admin and regular user roles
- **Alert Statistics**: Dashboard with key metrics

<!-- Add admin panel screenshot here -->

![Admin Panel](docs/images/admin-panel.png)

### 🌐 Real-time Features

- **Live Alert Updates**: New alerts appear without page refresh
- **Socket.IO Integration**: Bidirectional real-time communication
- **Event Broadcasting**: Laravel event system with Node.js server

<!-- Add real-time features screenshot here -->

![Real-time Updates](docs/images/realtime-screenshot.png)

### 🏠 Nearest Evacuation Shelters

- **Closest Shelter Lookup**: Automatically calculates nearest safe shelters relative to each saved address
- **Dynamic Radius Search**: Adjustable search radius (default configurable via `SHELTER_SEARCH_RADIUS_DEFAULT`)
- **Multi-Result Ranking**: Shelters ranked by distance and capacity; limits via `SHELTER_MAX_RESULTS`
- **Geo-optimized Queries**: Uses spatial indexing / Haversine formula for performant distance checks
- **User Context Integration**: Displays proximity warnings if no shelter falls within radius

<!-- Add shelter finder screenshot here -->

![Shelter Finder](docs/images/shelter-finder.png)

### 🤖 AI Disaster Prediction

- **Forecast Suggestions**: AI-assisted early warning hints before official alerts
- **Generative Explanation**: Human-readable summaries of risk factors (rainfall, wind, seismic patterns)
- **Confidence Scores**: Model returns probability & severity buckets (e.g. low / medium / high risk)
- **Model Isolation**: External prediction service consumed through REST (`PREDICTION_API_URL` / key)
- **Optional Feature Flag**: Toggle via `PREDICTION_ENABLED=true|false`
- **Provider Abstraction**: Supports multiple backends (e.g. Gemini / internal model) via `PREDICTION_PROVIDER`

<!-- Add AI prediction screenshot here -->

![AI Prediction](docs/images/ai-prediction.png)

## 🛠️ Technology Stack

### Backend

- **Framework**: Laravel 11.x
- **Database**: MySQL 8.0
- **PHP**: 8.2+
- **Authentication**: Laravel Breeze
- **ORM**: Eloquent
- **Real-time**: Laravel Events + Socket.IO

### Frontend

- **UI Framework**: Tailwind CSS 3.x
- **JavaScript**: Alpine.js 3.x
- **Build Tool**: Vite 7.x
- **Maps**: MapLibre GL JS
- **Real-time Client**: Socket.IO Client 4.8.x
- **HTTP Client**: Axios

### Real-time Server

- **Runtime**: Node.js
- **Framework**: Express 5.x
- **WebSocket**: Socket.IO 4.8.x
- **CORS**: Enabled for cross-origin requests

### DevOps

- **Containerization**: Docker & Docker Compose
- **Web Server**: Nginx
- **Cache**: Redis (optional)
- **Version Control**: Git

## 🚀 Getting Started

### Prerequisites

- PHP >= 8.2
- Composer
- Node.js >= 18.x
- npm or yarn
- MySQL >= 8.0
- Docker & Docker Compose (optional)

### Installation

For full installation steps, see: [docs/INSTALLATION.md](docs/INSTALLATION.md)

## 📁 Project Structure

```
SafeZoneVN/
├── SafeZone/              # Laravel application
│   ├── app/
│   │   ├── Http/Controllers/
│   │   ├── Models/
│   │   ├── Notifications/
│   │   └── Services/
│   ├── resources/
│   │   ├── views/         # Blade templates
│   │   └── js/           # Frontend assets
│   ├── routes/
│   ├── database/
│   └── public/
├── node-server/          # Real-time Socket.IO server
│   ├── server.js
│   └── package.json
├── nginx/               # Nginx configuration
├── mysql/               # MySQL data
└── docker-compose.yml   # Docker orchestration
```

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👥 Authors

- **Lê Đức Anh Tài** - _Initial work_ - [leducanhtai](https://github.com/leducanhtai)

## 🙏 Acknowledgments

- Laravel Framework
- MapLibre GL JS
- Socket.IO
- Tailwind CSS
- Alpine.js
- All contributors and testers

## 📧 Contact

For any inquiries or support, please contact:

- Email: taile13092k5@gmail.com.com
- GitHub: [@leducanhtai](https://github.com/leducanhtai)

---

Made with ❤️ for safer communities

</details>

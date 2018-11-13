# CrowdLogin for wordpress

開発: 松下 純 <jun@qiq.in>
旧開発: clifgriffin
タグ: Crowd, authentication, login
テスト環境: Wordpress Version 4.9.4 及び Crowd Version 3.0.1
バージョン: 0.2

## プラグインについて

このプラグインはAtlassian CrowdServer(以下Crowd)をWordpressと連携する為に使用します。

## 特徴

### 認証

  CrowdのREST APIを利用して認証しています。
  参照) https://docs.atlassian.com/atlassian-crowd/3.0.1/REST/

### ログインモード

  1. 自動作成モード(初期値): Crowdで認証が成功した場合、Wordpressにそのユーザがいなければ新規作成されます。
  2. 手動モード: Crowdで認証を行いますが、同じ名前のWordpressのアカウントを手動で作成する必要があります。

### セキュリティモード

  1. ノーマルモード(初期値): Crowd認証に失敗した場合はWordpressのユーザ認証を実行します。
  2. 高セキュリティモード: Crowd認証のみを実行します。

### CrowdのグループとWordpressの権限グループ(ロール)の紐付けについて

  - このプラグインはCrowdのグループとWordpressの権限グループを自動的に紐付けます
  - Crowdのグループは「アプリケーション名-Wordpressの権限グループ名」と定義される必要があります。
  - もしユーザが複数のグループに属している場合は「$wp_roles->roles」の取得順に紐付けされますが、基本的には一つのグループのみに属していた方が好ましいです。

  紐付け例
  - アプリケーション名: wp-test
  - Wordpress権限グループ: administrator(管理者) / editor(編集者) / subscriber(購読者)
  - Crowdグループ名
    - wp-test-administrator -> 認証成功後にWordpressの管理者権限に紐付けされます
    - wp-test-editor        -> 認証成功後にWordpressの編集者権限に紐付けされます
    - wp-test-subscriber    -> 認証成功後にWordpressの購読者権限に紐付けされます

### インストール手順

1. Crowd上でこのプラグインで使用するアプリケーション名とパスワードを作成します。
2. Wordpressの管理画面からこのプラグインをインストールするか、/wp-content/plugins/crowd-loginディレクトリに配置します。
3. Wordpressのプラグインメニューからこのプラグインを有効化します。
4. 設定 > Crowd認証のメニューに入り、Crowdの環境を設定します。
5. 初回のWordpressへのログインはWordpressの管理アカウントでログインして下さい。
6. 一旦Crowd認証が正しく設定された後は高セキュリティモードにしてCrowdのユーザのみがログインできるようにする事ができます。

### 更新履歴

**Version 0.1**
- 初期作成(clifgriffin)

**Version 0.2**
- Crowd REST APIを利用する様に改修
- CrowdグループとWordpress権限グループの紐付け機能を作成

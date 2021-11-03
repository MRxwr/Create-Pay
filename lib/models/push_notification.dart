class PushNotification {
  PushNotification({
    this.title,
    this.body,
    this.dataTitle,
    this.dataBody,
  });

  String title;
  String body;
  String dataTitle;
  String dataBody;

  factory PushNotification.fromJson(Map<String, dynamic> json) {
    print("-----888-----");
    print(json);
    return PushNotification(
      title: json["title"],
      body: json["body"],
      dataTitle: json["title"],
      dataBody: json["body"],
    );
  }
}

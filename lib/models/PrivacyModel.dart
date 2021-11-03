// To parse this JSON data, do
//
//     final privacyModel = privacyModelFromJson(jsonString);

import 'dart:convert';

PrivacyModel privacyModelFromJson(String str) => PrivacyModel.fromJson(json.decode(str));

String privacyModelToJson(PrivacyModel data) => json.encode(data.toJson());

class PrivacyModel {
    PrivacyModel({
        this.ok,
        this.status,
        this.details,
    });

    bool ok;
    int status;
    String details;

    factory PrivacyModel.fromJson(Map<String, dynamic> json) => PrivacyModel(
        ok: json["ok"],
        status: json["status"],
        details: json["details"],
    );

    Map<String, dynamic> toJson() => {
        "ok": ok,
        "status": status,
        "details": details,
    };
}

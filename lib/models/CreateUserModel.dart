// To parse this JSON data, do
//
//     final createUserModel = createUserModelFromJson(jsonString);

import 'dart:convert';

CreateUserModel createUserModelFromJson(String str) =>
    CreateUserModel.fromJson(json.decode(str));

String createUserModelToJson(CreateUserModel data) =>
    json.encode(data.toJson());

class CreateUserModel {
  CreateUserModel({
    this.ok,
    this.status,
    this.msg,
  });

  bool ok;
  int status;
  String msg;

  factory CreateUserModel.fromJson(Map<String, dynamic> json) =>
      CreateUserModel(
        ok: json["ok"],
        status: json["status"],
        msg: json["msg"],
      );

  Map<String, dynamic> toJson() => {
        "ok": ok,
        "status": status,
        "msg": msg,
      };
}

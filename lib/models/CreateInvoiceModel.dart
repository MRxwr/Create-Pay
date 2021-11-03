// To parse this JSON data, do
//
//     final createInvoiceModel = createInvoiceModelFromJson(jsonString);

import 'dart:convert';

CreateInvoiceModel createInvoiceModelFromJson(String str) =>
    CreateInvoiceModel.fromJson(json.decode(str));

String createInvoiceModelToJson(CreateInvoiceModel data) =>
    json.encode(data.toJson());

class CreateInvoiceModel {
  CreateInvoiceModel({
    this.ok,
    this.status,
    this.msg,
    this.details,
  });

  bool ok;
  int status;
  String msg;
  Details details;

  factory CreateInvoiceModel.fromJson(Map<String, dynamic> json) =>
      CreateInvoiceModel(
        ok: json["ok"],
        status: json["status"],
        msg: json["msg"],
        details: Details.fromJson(json["details"]),
      );

  Map<String, dynamic> toJson() => {
        "ok": ok,
        "status": status,
        "msg": msg,
        "details": details.toJson(),
      };
}

class Details {
  Details({
    this.link,
  });

  String link;

  factory Details.fromJson(Map<String, dynamic> json) => Details(
        link: json["Link"],
      );

  Map<String, dynamic> toJson() => {
        "Link": link,
      };
}

// To parse this JSON data, do
//
//     final generateInvoiceModel = generateInvoiceModelFromJson(jsonString);

import 'dart:convert';

GenerateInvoiceModel generateInvoiceModelFromJson(String str) => GenerateInvoiceModel.fromJson(json.decode(str));

String generateInvoiceModelToJson(GenerateInvoiceModel data) => json.encode(data.toJson());

class GenerateInvoiceModel {
    GenerateInvoiceModel({
        this.ok,
        this.status,
        this.msg,
        this.details,
    });

    bool ok;
    int status;
    String msg;
    Details details;

    factory GenerateInvoiceModel.fromJson(Map<String, dynamic> json) => GenerateInvoiceModel(
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

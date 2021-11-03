// To parse this JSON data, do
//
//     final invoicesListModel = invoicesListModelFromJson(jsonString);

import 'dart:convert';

InvoicesListModel invoicesListModelFromJson(String str) =>
    InvoicesListModel.fromJson(json.decode(str));

String invoicesListModelToJson(InvoicesListModel data) =>
    json.encode(data.toJson());

class InvoicesListModel {
  InvoicesListModel({
    this.ok,
    this.status,
    this.msg,
    this.details,
  });

  bool ok;
  int status;
  String msg;
  Details details;

  factory InvoicesListModel.fromJson(Map<String, dynamic> json) =>
      InvoicesListModel(
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
    this.invoices,
  });

  List<Invoice> invoices;

  factory Details.fromJson(Map<String, dynamic> json) => Details(
        invoices: List<Invoice>.from(
            json["invoices"].map((x) => Invoice.fromJson(x))),
      );

  Map<String, dynamic> toJson() => {
        "invoices": List<dynamic>.from(invoices.map((x) => x.toJson())),
      };
}

class Invoice {
  Invoice({
    this.date,
    this.link,
    this.customerName,
    this.customerMobile,
    this.customerEmail,
    this.invoicePrice,
    this.invoiceStatus,
  });

  DateTime date;
  String link;
  String customerName;
  String customerMobile;
  String customerEmail;
  String invoicePrice;
  String invoiceStatus;

  factory Invoice.fromJson(Map<String, dynamic> json) => Invoice(
        date: DateTime.parse(json["Date"]),
        link: json["Link"],
        customerName: json["CustomerName"],
        customerMobile: json["CustomerMobile"],
        customerEmail: json["CustomerEmail"],
        invoicePrice: json["InvoicePrice"],
        invoiceStatus: json["InvoiceStatus"],
      );

  Map<String, dynamic> toJson() => {
        "Date": date.toIso8601String(),
        "Link": link,
        "CustomerName": customerName,
        "CustomerMobile": customerMobile,
        "CustomerEmail": customerEmail,
        "InvoicePrice": invoicePrice,
        "InvoiceStatus": invoiceStatus,
      };
}

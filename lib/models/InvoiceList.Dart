// To parse this JSON data, do
//
//     final invoiceList = invoiceListFromJson(jsonString);

import 'dart:convert';

InvoiceList invoiceListFromJson(String str) =>
    InvoiceList.fromJson(json.decode(str));

String invoiceListToJson(InvoiceList data) => json.encode(data.toJson());

class InvoiceList {
  InvoiceList({
    this.ok,
    this.status,
    this.msg,
    this.details,
  });

  bool ok;
  int status;
  String msg;
  Details details;

  factory InvoiceList.fromJson(Map<String, dynamic> json) => InvoiceList(
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
    this.totalInvoicesTitle,
    this.totalInvoices,
    this.totalPaidTitle,
    this.totalPaid,
    this.totalPendingTitle,
    this.totalPending,
    this.totalFailedTitle,
    this.totalFailed,
    this.totalRefundedTitle,
    this.totalRefunded,
    this.totalExpiredTitle,
    this.totalExpired,
    this.earningsTitle,
    this.earnings,
  });

  String totalInvoicesTitle;
  String totalInvoices;
  String totalPaidTitle;
  String totalPaid;
  String totalPendingTitle;
  String totalPending;
  String totalFailedTitle;
  String totalFailed;
  String totalRefundedTitle;
  String totalRefunded;
  String totalExpiredTitle;
  String totalExpired;
  String earningsTitle;
  String earnings;

  factory Details.fromJson(Map<String, dynamic> json) => Details(
        totalInvoicesTitle: json["TotalInvoicesTitle"],
        totalInvoices: json["TotalInvoices"],
        totalPaidTitle: json["TotalPaidTitle"],
        totalPaid: json["TotalPaid"],
        totalPendingTitle: json["TotalPendingTitle"],
        totalPending: json["TotalPending"],
        totalFailedTitle: json["TotalFailedTitle"],
        totalFailed: json["TotalFailed"],
        totalRefundedTitle: json["TotalRefundedTitle"],
        totalRefunded: json["TotalRefunded"],
        totalExpiredTitle: json["TotalExpiredTitle"],
        totalExpired: json["TotalExpired"],
        earningsTitle: json["EarningsTitle"],
        earnings: json["Earnings"],
      );

  Map<String, dynamic> toJson() => {
        "TotalInvoicesTitle": totalInvoicesTitle,
        "TotalInvoices": totalInvoices,
        "TotalPaidTitle": totalPaidTitle,
        "TotalPaid": totalPaid,
        "TotalPendingTitle": totalPendingTitle,
        "TotalPending": totalPending,
        "TotalFailedTitle": totalFailedTitle,
        "TotalFailed": totalFailed,
        "TotalRefundedTitle": totalRefundedTitle,
        "TotalRefunded": totalRefunded,
        "TotalExpiredTitle": totalExpiredTitle,
        "TotalExpired": totalExpired,
        "EarningsTitle": earningsTitle,
        "Earnings": earnings,
      };
}

// To parse this JSON data, do
//
//     final invoicesList = invoicesListFromJson(jsonString);

import 'dart:convert';

InvoicesList invoicesListFromJson(String str) => InvoicesList.fromJson(json.decode(str));

String invoicesListToJson(InvoicesList data) => json.encode(data.toJson());

class InvoicesList {
    InvoicesList({
        this.ok,
        this.status,
        this.msg,
        this.details,
    });

    bool ok;
    int status;
    String msg;
    Details details;

    factory InvoicesList.fromJson(Map<String, dynamic> json) => InvoicesList(
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
        invoices: List<Invoice>.from(json["invoices"].map((x) => Invoice.fromJson(x))),
    );

    Map<String, dynamic> toJson() => {
        "invoices": List<dynamic>.from(invoices.map((x) => x.toJson())),
    };
}

class Invoice {
    Invoice({
        this.orderId,
        this.date,
        this.link,
        this.customerName,
        this.customerMobile,
        this.customerEmail,
        this.invoiceDetails,
        this.invoicePrice,
        this.invoiceStatus,
    });

    String orderId;
    DateTime date;
    String link;
    String customerName;
    String customerMobile;
    String customerEmail;
    String invoiceDetails;
    String invoicePrice;
    String invoiceStatus;

    factory Invoice.fromJson(Map<String, dynamic> json) => Invoice(
        orderId: json["orderId"],
        date: DateTime.parse(json["Date"]),
        link: json["Link"],
        customerName: json["CustomerName"],
        customerMobile: json["CustomerMobile"],
        customerEmail: json["CustomerEmail"],
        invoiceDetails: json["InvoiceDetails"],
        invoicePrice: json["InvoicePrice"],
        invoiceStatus: json["InvoiceStatus"],
    );

    Map<String, dynamic> toJson() => {
        "orderId": orderId,
        "Date": date.toIso8601String(),
        "Link": link,
        "CustomerName": customerName,
        "CustomerMobile": customerMobile,
        "CustomerEmail": customerEmail,
        "InvoiceDetails": invoiceDetails,
        "InvoicePrice": invoicePrice,
        "InvoiceStatus": invoiceStatus,
    };
}

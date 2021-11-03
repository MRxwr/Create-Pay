// To parse this JSON data, do
//
//     final refundModel = refundModelFromJson(jsonString);

import 'dart:convert';

RefundModel refundModelFromJson(String str) => RefundModel.fromJson(json.decode(str));

String refundModelToJson(RefundModel data) => json.encode(data.toJson());

class RefundModel {
    RefundModel({
        this.isSuccess,
        this.message,
        this.validationErrors,
        this.data,
    });

    bool isSuccess;
    String message;
    List<ValidationError> validationErrors;
    dynamic data;

    factory RefundModel.fromJson(Map<String, dynamic> json) => RefundModel(
        isSuccess: json["IsSuccess"],
        message: json["Message"],
        validationErrors: List<ValidationError>.from(json["ValidationErrors"].map((x) => ValidationError.fromJson(x))),
        data: json["Data"],
    );

    Map<String, dynamic> toJson() => {
        "IsSuccess": isSuccess,
        "Message": message,
        "ValidationErrors": List<dynamic>.from(validationErrors.map((x) => x.toJson())),
        "Data": data,
    };
}

class ValidationError {
    ValidationError({
        this.name,
        this.error,
    });

    String name;
    String error;

    factory ValidationError.fromJson(Map<String, dynamic> json) => ValidationError(
        name: json["Name"],
        error: json["Error"],
    );

    Map<String, dynamic> toJson() => {
        "Name": name,
        "Error": error,
    };
}

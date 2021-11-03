// To parse this JSON data, do
//
//     final userLoginModel = userLoginModelFromJson(jsonString);

import 'dart:convert';

UserLoginModel userLoginModelFromJson(String str) => UserLoginModel.fromJson(json.decode(str));

String userLoginModelToJson(UserLoginModel data) => json.encode(data.toJson());

class UserLoginModel {
    UserLoginModel({
        this.ok,
        this.status,
        this.msg,
        this.loginStatus,
        this.details,
    });

    bool ok;
    int status;
    String msg;
    int loginStatus;
    Details details;

    factory UserLoginModel.fromJson(Map<String, dynamic> json) => UserLoginModel(
        ok: json["ok"],
        status: json["status"],
        msg: json["msg"],
        loginStatus: json["loginStatus"],
        details: Details.fromJson(json["details"]),
    );

    Map<String, dynamic> toJson() => {
        "ok": ok,
        "status": status,
        "msg": msg,
        "loginStatus": loginStatus,
        "details": details.toJson(),
    };
}

class Details {
    Details({
        this.userId,
        this.name,
        this.email,
        this.refference,
    });

    String userId;
    String name;
    String email;
    String refference;

    factory Details.fromJson(Map<String, dynamic> json) => Details(
        userId: json["UserId"],
        name: json["name"],
        email: json["email"],
        refference: json["Refference"],
    );

    Map<String, dynamic> toJson() => {
        "UserId": userId,
        "name": name,
        "email": email,
        "Refference": refference,
    };
}

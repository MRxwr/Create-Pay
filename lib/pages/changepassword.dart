import 'package:create_pay/models/UpdatePasswordModel.dart';
import 'package:create_pay/pages/dashboard.dart';
import 'package:flutter/material.dart';
import 'package:form_field_validator/form_field_validator.dart';
import 'package:localize_and_translate/localize_and_translate.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:async';
import 'package:http/http.dart' as http;
import 'beziercontainer.dart';
import 'dart:math' as math;

class ChangePassword extends StatefulWidget {
  @override
  _ChangePasswordState createState() => _ChangePasswordState();
}

class _ChangePasswordState extends State<ChangePassword> {
  final _formKey = GlobalKey<FormState>();
  final GlobalKey<ScaffoldState> _scaffoldKey = new GlobalKey<ScaffoldState>();

  bool _obscureText1 = true;
  bool _obscureText2 = true;
  bool _obscureText3 = true;

  @override
  void initState() {
    super.initState();
  }

  var _currentPassword;
  var _newPassword;

  final currentPasswordController = new TextEditingController();
  final newPasswordController = new TextEditingController();
  final reNewPasswordController = new TextEditingController();

  _getURLValue(String key) async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String stringValue = prefs.getString(key);
    print(stringValue);
    return stringValue;
  }

  Future<UpdatePasswordModel> _fetchJobs() async {
    String currentLang = translator.translate('langCode');
    var url = Uri.parse(
        "https://createpay.link/api/editProfile.php?languageId=$currentLang");
    var reference = await _getURLValue('reference');

    Map<String, String> body = {
      'refference': reference,
      'newPassword': _newPassword,
      'password': _currentPassword
    };

    var response = await http.post(url,
        headers: <String, String>{
          'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
          'APPKEY': 'API123',
        },
        body: body);

    if (response.statusCode == 200) {
      UpdatePasswordModel data = updatePasswordModelFromJson(response.body);
      if (data.status == 200) {
        showAlertDialog(context, data.msg);
        //_showInSnackBar("Password Updated");

      } else {
        showAlertDialog(context, data.msg);
        //_showInSnackBar(data.msg);
      }
    } else {
      throw Exception('Failed to load jobs from API');
    }
  }

  showAlertDialog(BuildContext context, String msg) {
    // set up the buttons
    Widget continueButton = FlatButton(
      child: Text(
        translator.translate('btnOk'),
      ),
      onPressed: () => Navigator.push(
          context, MaterialPageRoute(builder: (context) => DashboardPage())),
    );

    // set up the AlertDialog
    AlertDialog alert = AlertDialog(
      title: Text(
        translator.translate('textAlert'),
      ),
      content: Text(msg),
      actions: [
        //cancelButton,
        continueButton,
      ],
    );

    // show the dialog
    showDialog(
      context: context,
      builder: (BuildContext context) {
        return alert;
      },
    );
  }

  Widget _title() {
    return Container(
      padding: EdgeInsets.only(
        top: 10,
      ),
      width: MediaQuery.of(context).size.width,
      child: Column(
        children: [
          Padding(
            padding: const EdgeInsets.all(0.0),
            child: Image(
              width: 160,
              image: AssetImage('assets/create_pay_logo_blue.png'),
            ),
          ),
        ],
      ),
    );
  }

  Widget _backButton() {
    return InkWell(
      onTap: () {
        Navigator.pop(context);
      },
      child: Container(
        padding: EdgeInsets.symmetric(horizontal: 10),
        child: Row(
          children: <Widget>[
            Container(
                padding: EdgeInsets.only(left: 0, top: 10, bottom: 10),
                child: //Icon(Icons.keyboard_arrow_left, color: Colors.black),
                    Transform(
                  alignment: Alignment.center,
                  transform: Matrix4.rotationY(
                      translator.isDirectionRTL(context) ? math.pi : 0),
                  child: Icon(
                    Icons.keyboard_arrow_left,
                  ),
                )),
            Text(translator.translate('textBack'),
                style: TextStyle(fontSize: 12, fontWeight: FontWeight.w500))
          ],
        ),
      ),
    );
  }

  Widget _entryFieldPassword() {
    return Container(
      margin: EdgeInsets.symmetric(vertical: 10),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: <Widget>[
          Text(
            translator.translate('textCurrentPassword'),
            style: TextStyle(fontWeight: FontWeight.normal, fontSize: 15),
          ),
          TextFormField(
              controller: currentPasswordController,
              onEditingComplete: () => context.nextEditableTextFocus(),
              validator: MultiValidator([
                RequiredValidator(errorText: "* Required"),
              ]),
              obscureText: _obscureText1,
              decoration: InputDecoration(
                  border: InputBorder.none,
                  fillColor: Color(0xfff3f3f4),
                  prefixIcon: Icon(Icons.lock),
                  filled: true,
                  suffixIcon: new GestureDetector(
                    onTap: () {
                      setState(() {
                        _obscureText1 = !_obscureText1;
                      });
                    },
                    child: new Icon(_obscureText1
                        ? Icons.visibility
                        : Icons.visibility_off),
                  ))),
          SizedBox(
            height: 10,
          ),
          Text(translator.translate('textNewPassword'),
              style: TextStyle(fontWeight: FontWeight.normal, fontSize: 15)),
          TextFormField(
              controller: newPasswordController,
              onEditingComplete: () => context.nextEditableTextFocus(),
              validator: MultiValidator([
                RequiredValidator(errorText: "* Required"),
                MinLengthValidator(8,
                    errorText: "Password should be atleast 8 characters")
              ]),
              obscureText: _obscureText2,
              decoration: InputDecoration(
                  border: InputBorder.none,
                  fillColor: Color(0xfff3f3f4),
                  prefixIcon: Icon(Icons.lock),
                  filled: true,
                  suffixIcon: new GestureDetector(
                    onTap: () {
                      setState(() {
                        _obscureText2 = !_obscureText2;
                      });
                    },
                    child: new Icon(_obscureText2
                        ? Icons.visibility
                        : Icons.visibility_off),
                  ))),
          SizedBox(
            height: 10,
          ),
          Text(
            translator.translate('textRetypeNewPassword'),
            style: TextStyle(fontWeight: FontWeight.normal, fontSize: 15),
          ),
          TextFormField(
              controller: reNewPasswordController,
              onEditingComplete: () => context.nextEditableTextFocus(),
              validator: MultiValidator([
                RequiredValidator(errorText: "* Required"),
              ]),
              obscureText: _obscureText3,
              decoration: InputDecoration(
                  border: InputBorder.none,
                  fillColor: Color(0xfff3f3f4),
                  prefixIcon: Icon(Icons.lock),
                  filled: true,
                  suffixIcon: new GestureDetector(
                    onTap: () {
                      setState(() {
                        _obscureText3 = !_obscureText3;
                      });
                    },
                    child: new Icon(_obscureText3
                        ? Icons.visibility
                        : Icons.visibility_off),
                  ))),
        ],
      ),
    );
  }

  Widget _submitButton(BuildContext context) {
    return Container(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Align(
            alignment: Alignment.center,
          ),
          Builder(
            builder: (context) => SizedBox(
              width: 220,
              child: RaisedButton.icon(
                textColor: Colors.white,
                color: Color(0xff297bb2),
                onPressed: () {
                  if (_formKey.currentState.validate()) {
                    // Scaffold.of(context).showSnackBar(
                    //     SnackBar(content: Text('Processing Data')));
                    setState(() {
                      if (newPasswordController.text ==
                          reNewPasswordController.text) {
                        _currentPassword = currentPasswordController.text;
                        _newPassword = newPasswordController.text;
                        _fetchJobs();
                      } else {
                        Scaffold.of(context).showSnackBar(
                            SnackBar(content: Text('Password not match')));
                      }
                    });
                  }
                },
                icon: Icon(Icons.login, size: 20),
                label: Text(translator.translate('textSubmit'),
                    style:
                        TextStyle(fontSize: 16, fontWeight: FontWeight.w500)),
              ),
            ),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    final height = MediaQuery.of(context).size.height;
    return Scaffold(
      key: _scaffoldKey,
      body: Container(
        child: Stack(
          children: [
            Positioned(
                top: -height * .2,
                right: -MediaQuery.of(context).size.width * .4,
                child: BezierContainer()),
            Positioned.directional(
                textDirection: Directionality.of(context),
                top: 40,
                child: _backButton()),
            Positioned(top: 40, left: 0, child: _title()),
            Container(
              margin: EdgeInsets.only(top: height / 4),
              //color: Colors.greenAccent,
              width: MediaQuery.of(context).size.width,
              child: Form(
                key: _formKey,
                child: ListView(
                  padding: EdgeInsets.all(16.0),
                  children: [
                    Center(
                      child: Text(
                        translator.translate('textUpdatePassword'),
                        style: TextStyle(
                            fontWeight: FontWeight.bold, fontSize: 15),
                      ),
                    ),
                    SizedBox(height: 20),
                    _entryFieldPassword(),
                    SizedBox(height: 20),
                    _submitButton(context),
                  ],
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }
}

extension Utility on BuildContext {
  void nextEditableTextFocus() {
    do {
      FocusScope.of(this).nextFocus();
    } while (FocusScope.of(this).focusedChild.context.widget is! EditableText);
  }
}

import 'package:create_pay/models/ForgetPasswordModel.dart';
import 'package:flutter/material.dart';
import 'package:form_field_validator/form_field_validator.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:localize_and_translate/localize_and_translate.dart';
import 'beziercontainer.dart';
import 'dashboard.dart';
import 'login.dart';
import 'dart:math' as math;
import 'dart:async';
import 'package:http/http.dart' as http;

class ForgotPassword extends StatefulWidget {
  ForgotPassword({Key key, this.title}) : super(key: key);

  final String title;

  @override
  _ForgotPasswordState createState() => _ForgotPasswordState();
}

class _ForgotPasswordState extends State<ForgotPassword> {
  final _formKey = GlobalKey<FormState>();
  final GlobalKey<ScaffoldState> _scaffoldKey = new GlobalKey<ScaffoldState>();

  @override
  void initState() {
    super.initState();
  }

  var _emailAddress;

  final emailController = new TextEditingController();

  _showInSnackBar(String value) {
    _scaffoldKey.currentState
        .showSnackBar(new SnackBar(content: new Text(value)));
  }

  Future<ForgetPasswordModel> _fetchJobs() async {
    String currentLang = translator.translate('langCode');
    var url = Uri.parse(
        "https://createpay.link/api/forgetPassword.php?languageId=$currentLang");
    Map<String, String> body = {
      'email': _emailAddress,
    };

    var response = await http.post(url,
        headers: <String, String>{
          'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
          'APPKEY': 'API123',
        },
        body: body);

    if (response.statusCode == 200) {
      ForgetPasswordModel data = forgetPasswordModelFromJson(response.body);
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
          context, MaterialPageRoute(builder: (context) => LoginPage())),
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

  @override
  Widget build(BuildContext context) {
    final height = MediaQuery.of(context).size.height;
    return Scaffold(
      key: _scaffoldKey,
      body: Container(
        height: height,
        child: Stack(
          children: <Widget>[
            Positioned(
              top: -MediaQuery.of(context).size.height * .15,
              right: -MediaQuery.of(context).size.width * .4,
              child: BezierContainer(),
            ),
            Container(
              padding: EdgeInsets.symmetric(horizontal: 20),
              child: SingleChildScrollView(
                child: Form(
                  key: _formKey,
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.center,
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: <Widget>[
                      SizedBox(height: height * .2),
                      _title(),
                      SizedBox(
                        height: 50,
                      ),
                      _entryFieldEmail(translator.translate('textEmail')),
                      SizedBox(
                        height: 20,
                      ),
                      _submitButton(context),
                    ],
                  ),
                ),
              ),
            ),
            Positioned.directional(
                textDirection: Directionality.of(context),
                top: 40,
                child: _backButton()),
          ],
        ),
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

  Widget _entryFieldEmail(String title, {bool isPassword = false}) {
    return Container(
      margin: EdgeInsets.symmetric(vertical: 10),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: <Widget>[
          Text(
            title,
            style: TextStyle(fontWeight: FontWeight.bold, fontSize: 15),
          ),
          SizedBox(
            height: 10,
          ),
          TextFormField(
              controller: emailController,
              validator: MultiValidator([
                RequiredValidator(errorText: "* Required"),
                EmailValidator(errorText: "Please enter valid email id"),
              ]),
              obscureText: isPassword,
              decoration: InputDecoration(
                  border: InputBorder.none,
                  fillColor: Color(0xfff3f3f4),
                  prefixIcon: Icon(Icons.email),
                  hintText: 'yourname@domain.com',
                  filled: true))
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
                    Scaffold.of(context).showSnackBar(
                        SnackBar(content: Text('Processing Data')));

                    setState(() {
                      _emailAddress = emailController.text;
                      _fetchJobs();
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

  Widget _loginAccountLabel() {
    return InkWell(
      onTap: () {
        Navigator.push(
            context, MaterialPageRoute(builder: (context) => LoginPage()));
      },
      child: Container(
        margin: EdgeInsets.symmetric(vertical: 20),
        padding: EdgeInsets.all(15),
        alignment: Alignment.bottomCenter,
        child: Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: <Widget>[
            Text(
              'Already have an account ?',
              style: TextStyle(fontSize: 13, fontWeight: FontWeight.w600),
            ),
            SizedBox(
              width: 10,
            ),
            Text(
              'Login',
              style: TextStyle(
                  color: Colors.blue,
                  fontSize: 13,
                  fontWeight: FontWeight.w600),
            ),
          ],
        ),
      ),
    );
  }

  Widget _title() {
    return Center(
      child: Image(
        width: 160,
        image: AssetImage('assets/create_pay_logo_blue.png'),
      ),
    );
  }
}

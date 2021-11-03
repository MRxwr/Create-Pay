import 'dart:convert';
import 'package:create_pay/_main.dart';
import 'package:create_pay/main.dart';
import 'package:create_pay/models/UserLoginModel.dart';
import 'package:create_pay/pages/dashboard.dart';
import 'package:create_pay/pages/forgotpassword.dart';
import 'package:create_pay/pages/signup.dart';
import 'package:flutter/material.dart';
import 'package:localize_and_translate/localize_and_translate.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:async';
import 'package:http/http.dart' as http;
import 'beziercontainer.dart';
import 'package:form_field_validator/form_field_validator.dart';

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return new MaterialApp(
      title: 'Flutter',
      theme: new ThemeData(
        primarySwatch: Colors.blue,
      ),
      home: new Scaffold(body: new LoginPage()),
    );
  }
}

class LoginPage extends StatefulWidget {
  @override
  _LoginPageState createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> {
  final _formKey = GlobalKey<FormState>();
  final GlobalKey<ScaffoldState> _scaffoldKey = new GlobalKey<ScaffoldState>();

  bool _obscureText = true;

  // Toggles the password show status
  // void _toggle() {
  //   setState(() {
  //     _obscureText = !_obscureText;
  //   });
  // }

  @override
  void initState() {
    super.initState();
  }

  UserLoginModel data;

  var _userName;
  var _userPassword;

  // final userNameController =
  //     new TextEditingController(text: 'nasserhatab1990@gmail.com');
  // final userPasswordController = new TextEditingController(text: '123456789');

  final userNameController = new TextEditingController();
  final userPasswordController = new TextEditingController();

  final FocusNode _fnUserName = FocusNode();
  final FocusNode _fnUserPassword = FocusNode();

  _showInSnackBar(String value) {
    _scaffoldKey.currentState
        .showSnackBar(new SnackBar(content: new Text(value)));
  }

  void _saveLoginValue(String userid, String name, String reference) async {
    SharedPreferences preferences = await SharedPreferences.getInstance();
    preferences.setString('userid', userid);
    preferences.setString('name', name);
    preferences.setString('reference', reference);
  }

  _getURLValue(String key) async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String stringValue = prefs.getString(key);
    print(stringValue);
    return stringValue;
  }

  Future<http.Response> _fetchJobs() async {
    String currentLang = translator.translate('langCode');
    var _token = await _getURLValue('token');
    print('token-login: $_token');

    var url = Uri.parse(
        'https://createpay.link/api/login.php?languageId=$currentLang');

    Map<String, String> body = {
      'APPKEY': 'API123',
      'email': _userName,
      'password': _userPassword,
      'token': _token
    };

    var response = await http.post(url,
        headers: <String, String>{
          'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
          'APPKEY': 'API123',
        },
        body: body);

    if (response.statusCode == 200) {
      setState(() {
        _load = false;
      });

      final responseJson = jsonDecode(response.body);
      print(responseJson['loginStatus']);

      if (responseJson['loginStatus'] == 3) {
        data = userLoginModelFromJson(response.body);
        _saveLoginValue(data.details.userId, data.details.name,
            data.details.refference); //data.details.refference
        if (data.details.refference.isNotEmpty) {
          Navigator.push(context,
              MaterialPageRoute(builder: (context) => DashboardPage()));
        } else {
          _showInSnackBar("Reference Null");
        }
      } else if (responseJson['loginStatus'] == 2) {
        showAlertDialog(context, responseJson['msg']);
        //_showInSnackBar("Your account has been disabled");
      } else if (responseJson['loginStatus'] == 1) {
        showAlertDialog(context, responseJson['msg']);
        //_showInSnackBar("Account under process");
      } else if (responseJson['loginStatus'] == 0) {
        showAlertDialog(context, responseJson['msg']);
        //_showInSnackBar("Enter your info correctly");
      } else {
        print('error');
        _showInSnackBar("login error");
      }
    } else {
      throw Exception('Failed to load jobs from API');
    }

    print(body);
    print("${response.statusCode}");
    print("${response.body}");
    Text('URL: ${response.statusCode}');
    return response;
  }

  showAlertDialog(BuildContext context, String msg) {
    // set up the buttons
    Widget continueButton = TextButton(
      child: Text(
        translator.translate('btnOk'),
      ),
      onPressed: () => Navigator.pop(context),
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

  bool _load = false;

  @override
  Widget build(BuildContext context) {
    final height = MediaQuery.of(context).size.height;

    Widget loadingIndicator = _load
        ? new Column(
            crossAxisAlignment: CrossAxisAlignment.center,
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              new Center(
                child: new SizedBox(
                  height: 50.0,
                  width: 50.0,
                  child: new CircularProgressIndicator(
                    value: null,
                    strokeWidth: 7.0,
                  ),
                ),
              )
            ],
          )
        : new Container();

    return WillPopScope(
      onWillPop: () async => false,
      child: Scaffold(
          key: _scaffoldKey,
          body: Container(
            height: height,
            child: Stack(
              children: <Widget>[
                Positioned(
                    top: -height * .15,
                    right: -MediaQuery.of(context).size.width * .4,
                    child: BezierContainer()),
                Positioned(top: 40, left: 0, child: _backButton()),
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
                          SizedBox(height: 50),
                          _emailPasswordWidget(),
                          SizedBox(height: 20),
                          _submitButton(context),
                          TextButton(
                              child: Text(
                                  translator.translate('textForgotPassword'),
                                  style: TextStyle(
                                      fontSize: 14,
                                      fontWeight: FontWeight.w500)),
                              onPressed: () {
                                print('Pressed');
                                Navigator.push(
                                    context,
                                    MaterialPageRoute(
                                        builder: (context) =>
                                            ForgotPassword()));
                              }),
                          SizedBox(height: height * .055),
                          _createAccountLabel(),
                        ],
                      ),
                    ),
                  ),
                ),
                new Align(
                  child: loadingIndicator,
                  alignment: FractionalOffset.center,
                ),
              ],
            ),
          )),
    );
  }

  Widget _backButton() {
    return InkWell(
      onTap: () {
        Navigator.push(
            context, MaterialPageRoute(builder: (context) => HomePage()));
      },
      child: Container(
        padding: EdgeInsets.symmetric(horizontal: 10),
        child: Row(
          children: <Widget>[
            Container(
              padding: EdgeInsets.only(left: 0, top: 10, bottom: 10),
              child: Icon(Icons.home, color: Colors.black),
            ),
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
              controller: userNameController,
              textInputAction: TextInputAction.next,
              focusNode: _fnUserName,
              onFieldSubmitted: (term) {
                _fieldFocusChange(context, _fnUserName, _fnUserPassword);
              },
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

  Widget _entryFieldPassword(String title, {bool isPassword = false}) {
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
              controller: userPasswordController,
              textInputAction: TextInputAction.go,
              focusNode: _fnUserPassword,
              onFieldSubmitted: (term) {
                _fnUserPassword.unfocus();
                _login();
              },
              validator: MultiValidator([
                RequiredValidator(errorText: "* Required"),
                MinLengthValidator(8,
                    errorText: "Password should be atleast 8 characters")
              ]),
              obscureText: _obscureText,
              decoration: InputDecoration(
                  border: InputBorder.none,
                  fillColor: Color(0xfff3f3f4),
                  prefixIcon: Icon(Icons.lock),
                  filled: true,
                  suffixIcon: new GestureDetector(
                    onTap: () {
                      setState(() {
                        _obscureText = !_obscureText;
                      });
                    },
                    child: new Icon(
                        _obscureText ? Icons.visibility : Icons.visibility_off),
                  ))),
        ],
      ),
    );
  }

  void _login() {
    if (_formKey.currentState.validate()) {
      // Scaffold.of(context)
      //     .showSnackBar(SnackBar(content: Text('Processing Data')));
      setState(() {
        _load = true;
        _userName = userNameController.text;
        _userPassword = userPasswordController.text;
        _fetchJobs();
      });
    }
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
                      _userName = userNameController.text;
                      _userPassword = userPasswordController.text;
                      _fetchJobs();
                    });
                  }
                },
                icon: Icon(Icons.login, size: 20),
                label: Text(translator.translate('textLogin'),
                    style:
                        TextStyle(fontSize: 16, fontWeight: FontWeight.w500)),
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _createAccountLabel() {
    return InkWell(
      onTap: () {
        Navigator.push(
            context, MaterialPageRoute(builder: (context) => SignUpPage()));
      },
      child: Container(
        margin: EdgeInsets.symmetric(vertical: 20),
        padding: EdgeInsets.all(15),
        alignment: Alignment.bottomCenter,
        child: Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: <Widget>[
            Text(
              translator.translate('textNoAccount'),
              style: TextStyle(fontSize: 13, fontWeight: FontWeight.w600),
            ),
            SizedBox(
              width: 10,
            ),
            Text(
              translator.translate('textRegister'),
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
        //image: NetworkImage(
        //    'https://flutter.dev/assets/flutter-lockup-1caf6476beed76adec3c477586da54de6b552b2f42108ec5bc68dc63bae2df75.png'),
      ),
    );
  }

  Widget _emailPasswordWidget() {
    return Column(
      children: <Widget>[
        _entryFieldEmail(
          translator.translate('textEmail'),
        ),
        _entryFieldPassword(translator.translate('textPassword'),
            isPassword: true),
      ],
    );
  }

  _fieldFocusChange(
      BuildContext context, FocusNode currentFocus, FocusNode nextFocus) {
    currentFocus.unfocus();
    FocusScope.of(context).requestFocus(nextFocus);
  }
}

import 'package:create_pay/helpers/header_screen.dart';
import 'package:create_pay/pages/login.dart';
import 'package:flutter/material.dart';
import 'package:form_field_validator/form_field_validator.dart';
import 'dart:io';
import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:image_picker/image_picker.dart';
import 'package:intl_phone_field/intl_phone_field.dart';
import 'package:localize_and_translate/localize_and_translate.dart';
import 'package:shared_preferences/shared_preferences.dart';
import '../models/CreateUserModel.dart';

class SignUpPage extends StatefulWidget {
  SignUpPage() : super();
  final String title = "Upload Image Demo";
  @override
  SignUpPageState createState() => SignUpPageState();
}

class SignUpPageState extends State<SignUpPage> {
  final _formKey = GlobalKey<FormState>();
  final GlobalKey<ScaffoldState> _scaffoldKey = new GlobalKey<ScaffoldState>();

  bool _obscureText = true;
  String currentLang = translator.translate('langCode');

  _getURLValue(String key) async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String stringValue = prefs.getString(key);
    print(stringValue);
    return stringValue;
  }

  static final String uploadEndPoint =
      'https://createpay.link/api/createUser.php?languageId=$translator.translate("langCode")';

  var _userName;
  var _userEmail;
  var _userMobile;
  var _userPassword;
  var _userInstagram;

  final userNameController = new TextEditingController();
  final userEmailController = new TextEditingController();
  final userMobileController = new TextEditingController();
  final userPasswordController = new TextEditingController();
  final userInstagramController = new TextEditingController();

  final FocusNode _fnUserName = FocusNode();
  final FocusNode _fnUserEmail = FocusNode();
  final FocusNode _fnUserMobile = FocusNode();
  final FocusNode _fnUserPassword = FocusNode();
  final FocusNode _fnUserInstagram = FocusNode();

  //Future<File> file, instagram, idfront, idback, profile;

  File instagram, idfront, idback, profile;

  String status = '';
  String base64Image;
  String _errorMsg;

  File tmpFile;
  //File tmpinstagram, tmpidfront, tmpidback, tmpprofile;

  String errMessage = 'Error Uploading Image';

  final picker = ImagePicker();

  Future chooseInstagram() async {
    PickedFile pickedInstagramFile =
        await picker.getImage(source: ImageSource.gallery);
    setState(() {
      instagram = File(pickedInstagramFile.path);
    });
  }

  Future chooseIDFront() async {
    PickedFile pickedFrontFile =
        await picker.getImage(source: ImageSource.gallery);
    setState(() {
      idfront = File(pickedFrontFile.path);
    });
  }

  Future chooseIDBack() async {
    PickedFile pickedBackFile =
        await picker.getImage(source: ImageSource.gallery);
    setState(() {
      idback = File(pickedBackFile.path);
    });
  }

  Future chooseProfile() async {
    PickedFile pickedProfileFile =
        await picker.getImage(source: ImageSource.gallery);
    setState(() {
      profile = File(pickedProfileFile.path);
    });
  }

  setStatus(String message) {
    setState(() {
      status = message;
    });
  }

  startUpload(BuildContext context) {
    setStatus('Uploading Image...');
    if (null == instagram ||
        null == idfront ||
        null == idback ||
        null == profile) {
      Scaffold.of(context)
          .showSnackBar(SnackBar(content: Text('Please add all images.')));

      return;
    }

    _uploadJobs(instagram, idfront, idback, profile, _userName, _userMobile,
        _userEmail, _userPassword, _userInstagram);
  }

  Future<http.Response> _uploadJobs(
      File instagramFile,
      File idfrontFile,
      File idbackFile,
      File profileFile,
      String name,
      String mobile,
      String email,
      String password,
      String instagram) async {
    var _token = await _getURLValue('token');
    print('token-login: $_token');
    var uri = Uri.parse("https://createpay.link/api/createUser.php");

    // create multipart request
    var request = new http.MultipartRequest("POST", uri);
    request.fields['name'] = name;
    request.fields['mobile'] = mobile;
    request.fields['email'] = email;
    request.fields['password'] = password;
    request.fields['instagram'] = instagram;
    request.fields['token'] = _token;
    request.files.add(
        await http.MultipartFile.fromPath('instaProfile', instagramFile.path));
    request.files
        .add(await http.MultipartFile.fromPath('civilIdF', idfrontFile.path));
    request.files
        .add(await http.MultipartFile.fromPath('civilIdB', idbackFile.path));
    request.files.add(
        await http.MultipartFile.fromPath('profileImage', profileFile.path));

    var response = await request.send();

    // Extract String from Streamed Response
    //var responseString = await response.stream.bytesToString();

    // listen for response

    if (response.statusCode == 200) {
      response.stream.transform(utf8.decoder).listen((value) {
        print('value: $value');
        CreateUserModel xx = createUserModelFromJson(value);
        showAlertDialog(context, xx.msg);
        print(xx.msg);
      });
    } else {
      print('error uploading');
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
        body: Column(
          children: <Widget>[
            Container(
              height: (MediaQuery.of(context).size.height / 4) + 30,
              child: Container(child: HeaderScreen()),
            ),
            Expanded(
              flex: 1,
              child: Container(
                //color: Colors.amber,
                width: double.infinity,
                padding: EdgeInsets.symmetric(horizontal: 20),
                child: SingleChildScrollView(
                  child: Form(
                    key: _formKey,
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.stretch,
                      mainAxisAlignment: MainAxisAlignment.start,
                      children: <Widget>[
                        SizedBox(height: 0),
                        _allInputWidget(),
                        SizedBox(height: 40),
                        Column(
                          children: [
                            Row(
                              children: [
                                Expanded(
                                  child: RaisedButton.icon(
                                    textColor: Colors.white,
                                    color: Color(0xff297bb2),
                                    onPressed: chooseInstagram,
                                    icon: Icon(Icons.photo, size: 20),
                                    label: Text(
                                        translator.translate('textInstagram'),
                                        style: TextStyle(
                                            fontSize: 16,
                                            fontWeight: FontWeight.w500)),
                                  ),
                                ),
                                SizedBox(
                                  width: 10,
                                ),
                                Expanded(
                                  child: instagram == null
                                      ? Icon(Icons.photo,
                                          color: Colors.lightBlue[200],
                                          size: 120)
                                      : Image.file(instagram,
                                          width: 100,
                                          height: 100,
                                          fit: BoxFit.fill),
                                )
                              ],
                            ),
                            SizedBox(
                              height: 10,
                            ),
                            Row(
                              children: [
                                Expanded(
                                  child: RaisedButton.icon(
                                    textColor: Colors.white,
                                    color: Color(0xff297bb2),
                                    onPressed: chooseIDFront,
                                    icon: Icon(Icons.photo, size: 20),
                                    label: Text(
                                        translator.translate('textIDFront'),
                                        style: TextStyle(
                                            fontSize: 16,
                                            fontWeight: FontWeight.w500)),
                                  ),
                                ),
                                SizedBox(
                                  width: 20,
                                ),
                                Expanded(
                                  child: idfront == null
                                      ? Icon(Icons.photo,
                                          color: Colors.lightBlue[200],
                                          size: 120)
                                      : Image.file(idfront,
                                          width: 100,
                                          height: 100,
                                          fit: BoxFit.fill),
                                )
                              ],
                            ),
                            SizedBox(
                              height: 10,
                            ),
                            Row(
                              children: [
                                Expanded(
                                  child: RaisedButton.icon(
                                    textColor: Colors.white,
                                    color: Color(0xff297bb2),
                                    onPressed: chooseIDBack,
                                    icon: Icon(Icons.photo, size: 20),
                                    label: Text(
                                        translator.translate('textIDBack'),
                                        style: TextStyle(
                                            fontSize: 16,
                                            fontWeight: FontWeight.w500)),
                                  ),
                                ),
                                SizedBox(
                                  width: 20,
                                ),
                                Expanded(
                                  child: idback == null
                                      ? Icon(Icons.photo,
                                          color: Colors.lightBlue[200],
                                          size: 120)
                                      : Image.file(idback,
                                          width: 100,
                                          height: 100,
                                          fit: BoxFit.fill),
                                )
                              ],
                            ),
                            SizedBox(
                              height: 10,
                            ),
                            Row(
                              children: [
                                Expanded(
                                  child: RaisedButton.icon(
                                    textColor: Colors.white,
                                    color: Color(0xff297bb2),
                                    onPressed: chooseProfile,
                                    icon: Icon(Icons.photo, size: 20),
                                    label: Text(
                                        translator.translate('textLogo'),
                                        style: TextStyle(
                                            fontSize: 16,
                                            fontWeight: FontWeight.w500)),
                                  ),
                                ),
                                SizedBox(
                                  width: 20,
                                ),
                                Expanded(
                                  child: profile == null
                                      ? Icon(Icons.photo,
                                          color: Colors.lightBlue[200],
                                          size: 120)
                                      : Image.file(profile,
                                          width: 100,
                                          height: 100,
                                          fit: BoxFit.fill),
                                )
                              ],
                            ),
                          ],
                        ),
                        SizedBox(
                          height: 20.0,
                        ),
                        Builder(
                          builder: (context) => RaisedButton.icon(
                            textColor: Colors.white,
                            color: Color(0xff297bb2),
                            onPressed: () {
                              if (_formKey.currentState.validate()) {
                                setState(() {
                                  _userName = userNameController.text;
                                  _userMobile =
                                      (userMobileController.text).substring(1);
                                  _userEmail = userEmailController.text;
                                  _userPassword = userPasswordController.text;
                                  _userInstagram = userInstagramController.text;
                                  startUpload(context);
                                  print(_userName);
                                });
                              }
                            },
                            icon: Icon(Icons.app_registration, size: 20),
                            label: Text(translator.translate('textRegister'),
                                style: TextStyle(
                                    fontSize: 16, fontWeight: FontWeight.w500)),
                          ),
                        ),
                        SizedBox(height: height * .055),
                      ],
                    ),
                  ),
                ),
              ),
            )
          ],
        ));
  }

  Widget _allInputWidget() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      mainAxisAlignment: MainAxisAlignment.start,
      children: <Widget>[
        SizedBox(
          height: 30,
        ),
        Text(translator.translate('textUserName'),
            style: TextStyle(fontWeight: FontWeight.normal)),
        TextFormField(
            controller: userNameController,
            textInputAction: TextInputAction.next,
            focusNode: _fnUserName,
            onFieldSubmitted: (term) {
              _fieldFocusChange(context, _fnUserName, _fnUserMobile);
            },
            validator: MultiValidator([
              RequiredValidator(errorText: "* Required"),
            ]),
            decoration: InputDecoration(
                border: InputBorder.none,
                fillColor: Color(0xfff3f3f4),
                prefixIcon: Icon(Icons.person),
                //hintText: 'yourname@domain.com',
                filled: true)),
        SizedBox(
          height: 30,
        ),
        Text(translator.translate('textMobile'),
            style: TextStyle(fontWeight: FontWeight.normal)),

        IntlPhoneField(
          //controller: userMobileController,
          textInputAction: TextInputAction.next,
          focusNode: _fnUserMobile,
          onSubmitted: (term) {
            _fieldFocusChange(context, _fnUserMobile, _fnUserEmail);
          },
          decoration: InputDecoration(
              border: InputBorder.none,
              fillColor: Color(0xfff3f3f4),
              filled: true),
          initialCountryCode: 'KW',
          autoValidate: false,
          validator: MultiValidator([
            PatternValidator(r'^[0-9]*$',
                errorText: 'Only numbers are accepted'),
            RequiredValidator(errorText: "* Required"),
            LengthRangeValidator(
                errorText: "Mobile should be 8 characters", max: 8, min: 8),
          ]),
          onChanged: (phone) {
            userMobileController.text = phone.completeNumber;
            print(phone.completeNumber);
          },
        ),

        // TextFormField(
        //     controller: userMobileController,
        //     keyboardType: TextInputType.number,
        //     textInputAction: TextInputAction.next,
        //     focusNode: _fnUserMobile,
        //     onFieldSubmitted: (term) {
        //       _fieldFocusChange(context, _fnUserMobile, _fnUserEmail);
        //     },
        //     validator: MultiValidator([
        //       RequiredValidator(errorText: "* Required"),
        //       MinLengthValidator(12,
        //           errorText: "Mobile should be atleast 12 characters")
        //     ]),
        //     decoration: InputDecoration(
        //         border: InputBorder.none,
        //         fillColor: Color(0xfff3f3f4),
        //         prefixIcon: Icon(Icons.phone),
        //         //hintText: 'yourname@domain.com',
        //         filled: true)),

        SizedBox(
          height: 30,
        ),
        Text(translator.translate('textEmail'),
            style: TextStyle(fontWeight: FontWeight.normal)),
        TextFormField(
            controller: userEmailController,
            textInputAction: TextInputAction.next,
            focusNode: _fnUserEmail,
            onFieldSubmitted: (term) {
              _fieldFocusChange(context, _fnUserEmail, _fnUserPassword);
            },
            validator: MultiValidator([
              RequiredValidator(errorText: "* Required"),
              EmailValidator(errorText: "Please enter valid email id"),
            ]),
            decoration: InputDecoration(
                border: InputBorder.none,
                fillColor: Color(0xfff3f3f4),
                prefixIcon: Icon(Icons.email),
                hintText: 'yourname@domain.com',
                filled: true)),
        SizedBox(
          height: 30,
        ),
        Text(translator.translate('textPassword'),
            style: TextStyle(fontWeight: FontWeight.normal)),
        TextFormField(
            controller: userPasswordController,
            textInputAction: TextInputAction.next,
            focusNode: _fnUserPassword,
            onFieldSubmitted: (term) {
              _fieldFocusChange(context, _fnUserPassword, _fnUserInstagram);
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
                prefixIcon: Icon(Icons.security),
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
        SizedBox(
          height: 30,
        ),
        Text(translator.translate('textInstagramID'),
            style: TextStyle(fontWeight: FontWeight.normal)),
        TextFormField(
            controller: userInstagramController,
            focusNode: _fnUserInstagram,
            textInputAction: TextInputAction.go,
            onFieldSubmitted: (term) {
              _fnUserInstagram.unfocus();
              //useraction
            },
            validator: MultiValidator([
              RequiredValidator(errorText: "* Required"),
            ]),
            decoration: InputDecoration(
                border: InputBorder.none,
                fillColor: Color(0xfff3f3f4),
                prefixIcon: Icon(Icons.web),
                //hintText: 'yourname@domain.com',
                filled: true)),
      ],
    );
  }

  _fieldFocusChange(
      BuildContext context, FocusNode currentFocus, FocusNode nextFocus) {
    currentFocus.unfocus();
    FocusScope.of(context).requestFocus(nextFocus);
  }
}

extension Utility on BuildContext {
  void nextEditableTextFocus() {
    do {
      FocusScope.of(this).nextFocus();
    } while (FocusScope.of(this).focusedChild.context.widget is! EditableText);
  }
}

import 'package:create_pay/models/GenerateInvoiceModel.dart';
import 'package:create_pay/pages/paymenturl.dart';
import 'package:flutter/material.dart';
import 'package:localize_and_translate/localize_and_translate.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:async';
import 'package:http/http.dart' as http;
import 'package:form_field_validator/form_field_validator.dart';
import 'package:create_pay/helpers/header_screen.dart';
import 'package:intl_phone_field/intl_phone_field.dart';

class CreateBill extends StatefulWidget {
  @override
  _CreateBillState createState() => _CreateBillState();
}

class _CreateBillState extends State<CreateBill> {
  final _formKey = GlobalKey<FormState>();
  GenerateInvoiceModel data;

  var _customerName;
  var _customerEmail;
  var _customerMobile;
  var _customerPrice;
  var _customerDetails;

  final customerNameController = new TextEditingController();
  final customerEmailController = new TextEditingController();
  final customerMobileController = new TextEditingController();
  final customerPriceController = new TextEditingController();
  final customerDetailsController = new TextEditingController();

  final FocusNode _fnCustomerName = FocusNode();
  final FocusNode _fnCustomerEmail = FocusNode();
  final FocusNode _fnCustomerMobile = FocusNode();
  final FocusNode _fnCustomerPrice = FocusNode();
  final FocusNode _fnCustomerDetails = FocusNode();

  void _saveURLValue(String url) async {
    SharedPreferences preferences = await SharedPreferences.getInstance();
    preferences.setString('paymenturl', url);
  }

  _getURLValue(String key) async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String stringValue = prefs.getString(key);
    print(stringValue);
    return stringValue;
  }

  Future<http.Response> _fetchJobs() async {
    String currentLang = translator.translate('langCode');
    var url = Uri.parse(
        'https://createpay.link/api/CreateInvoice.php?languageId=$currentLang');

    var reference = await _getURLValue('reference');
    print('Ref: ' + reference);

    Map<String, String> body = {
      'APPKEY': 'API123',
      'name': _customerName,
      'email': _customerEmail,
      'mobile': _customerMobile,
      'price': _customerPrice,
      'details': _customerDetails,
      'refference': reference,
    };

    var response = await http.post(url,
        headers: <String, String>{
          'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
          'APPKEY': 'API123',
        },
        body: body);

    print(response);

    if (response.statusCode == 200) {
      print('----- AAAA -----');
      data = generateInvoiceModelFromJson(response.body);
      _saveURLValue(data.details.link);
      showAlertDialog(context, data.msg);
    } else {
      showAlertDialog(context, data.msg);
      throw Exception('Failed to load jobs from API');
    }

    print('----- BBBB -----');
    print(body);
    print("${response.statusCode}");
    print("${response.body}");
    Text('URL: ${response.statusCode}');
    return response;
  }

  showAlertDialog(BuildContext context, String msg) {
    Widget continueButton = FlatButton(
      child: Text(
        translator.translate('btnOk'),
      ),
      onPressed: () {
        Navigator.push(
            context,
            MaterialPageRoute(
                builder: (context) => PaymentURL(), fullscreenDialog: true));
      },
    );

    // set up the AlertDialog
    AlertDialog alert = AlertDialog(
      title: Text(
        translator.translate('textAlert'),
      ),
      content: Text(msg),
      actions: [
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

  String _phoneNumberValidator(String value) {
    Pattern pattern = r'/^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/';
    RegExp regex = new RegExp(pattern);
    if (!regex.hasMatch(value))
      return 'Enter Valid Phone Number';
    else
      return null;
  }

  Widget _displayDetails() {
    return Container(
      alignment: Alignment.center,
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Align(
            alignment: Alignment.centerLeft,
          ),
          SizedBox(
            height: 30,
          ),
          Text(translator.translate('textName'),
              style: TextStyle(fontWeight: FontWeight.normal)),
          TextFormField(
              controller: customerNameController,
              textInputAction: TextInputAction.next,
              focusNode: _fnCustomerName,
              onFieldSubmitted: (term) {
                _fieldFocusChange(context, _fnCustomerName, _fnCustomerEmail);
              },
              // validator: MultiValidator([
              //   RequiredValidator(errorText: "* Required"),
              // ]),
              decoration: InputDecoration(
                  border: InputBorder.none,
                  fillColor: Color(0xfff3f3f4),
                  prefixIcon: Icon(Icons.person),
                  filled: true)),
          SizedBox(
            height: 30,
          ),
          Text(translator.translate('textEmail'),
              style: TextStyle(fontWeight: FontWeight.normal)),
          TextFormField(
              controller: customerEmailController,
              textInputAction: TextInputAction.next,
              focusNode: _fnCustomerEmail,
              onFieldSubmitted: (term) {
                _fieldFocusChange(context, _fnCustomerEmail, _fnCustomerMobile);
              },
              // validator: MultiValidator([
              //   RequiredValidator(errorText: "* Required"),
              //   EmailValidator(errorText: "Please enter valid email id"),
              // ]),
              decoration: InputDecoration(
                  border: InputBorder.none,
                  fillColor: Color(0xfff3f3f4),
                  prefixIcon: Icon(Icons.email),
                  hintText: 'yourname@domain.com',
                  filled: true)),
          SizedBox(
            height: 30,
          ),
          Text(translator.translate('textMobile'),
              style: TextStyle(fontWeight: FontWeight.normal)),
          IntlPhoneField(
            //controller: userMobileController,

            textInputAction: TextInputAction.next,
            focusNode: _fnCustomerMobile,
            onSubmitted: (term) {
              _fieldFocusChange(context, _fnCustomerMobile, _fnCustomerPrice);
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
              customerMobileController.text = phone.completeNumber;
              print(phone.completeNumber);
            },
          ),
          SizedBox(
            height: 30,
          ),
          Text(translator.translate('textAmount'),
              style: TextStyle(fontWeight: FontWeight.normal)),
          TextFormField(
              keyboardType: TextInputType.numberWithOptions(decimal: true),
              controller: customerPriceController,
              textInputAction: TextInputAction.next,
              focusNode: _fnCustomerPrice,
              onFieldSubmitted: (term) {
                _fieldFocusChange(
                    context, _fnCustomerPrice, _fnCustomerDetails);
              },
              validator: MultiValidator([
                RequiredValidator(errorText: "* Required"),
                PatternValidator('[+-]?([0-9]*{.}1)?[0-9]+\$',
                    errorText: 'Accept only numbers')
              ]),
              decoration: InputDecoration(
                  hintText: '0.000',
                  border: InputBorder.none,
                  fillColor: Color(0xfff3f3f4),
                  prefixIcon: Icon(Icons.money),
                  suffix: Text(
                    'KWD',
                    style: TextStyle(fontWeight: FontWeight.bold),
                  ),
                  suffixIconConstraints:
                      BoxConstraints(minWidth: 0, minHeight: 0),
                  filled: true)),
          SizedBox(
            height: 30,
          ),
          Text(translator.translate('textDetails'),
              style: TextStyle(fontWeight: FontWeight.normal)),
          TextFormField(
              controller: customerDetailsController,
              textInputAction: TextInputAction.next,
              focusNode: _fnCustomerDetails,
              onFieldSubmitted: (term) {
                _fnCustomerDetails.unfocus();
              },
              validator: MultiValidator([
                RequiredValidator(errorText: "* Required"),
              ]),
              decoration: InputDecoration(
                  border: InputBorder.none,
                  fillColor: Color(0xfff3f3f4),
                  prefixIcon: Icon(Icons.notes),
                  filled: true)),
          SizedBox(
            height: 30,
          ),
          Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Align(
                alignment: Alignment.center,
              ),
              RaisedButton.icon(
                textColor: Colors.white,
                color: Color(0xff297bb2),
                onPressed: () {
                  if (_formKey.currentState.validate()) {
                    setState(() {
                      _customerName = customerNameController.text;
                      _customerEmail = customerEmailController.text;
                      _customerMobile =
                          (customerMobileController.text).substring(1);
                      _customerPrice = customerPriceController.text;
                      _customerDetails = customerDetailsController.text;

                      _fetchJobs();
                    });
                  }
                },
                icon: Icon(Icons.login, size: 20),
                label: Text(translator.translate('textCreateInvoice'),
                    style:
                        TextStyle(fontSize: 16, fontWeight: FontWeight.w500)),
              ),
            ],
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    final height = MediaQuery.of(context).size.height;
    return Scaffold(
        body: Column(
      children: <Widget>[
        Container(
          height: (MediaQuery.of(context).size.height / 4) + 30,
          child: Container(child: HeaderScreen()),
        ),
        Expanded(
          flex: 3,
          child: Container(
            //color: Colors.amber,
            width: double.infinity,
            padding: EdgeInsets.symmetric(horizontal: 20),
            child: SingleChildScrollView(
              child: Form(
                //padding: EdgeInsets.symmetric(horizontal: 20),
                key: _formKey,
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.center,
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: <Widget>[
                    Container(
                      padding: EdgeInsets.symmetric(vertical: 10),
                      alignment: Alignment.center,
                      child: Text(translator.translate('textCreateInvoice'),
                          style: TextStyle(
                              fontWeight: FontWeight.bold, fontSize: 21)),
                    ),
                    _displayDetails(),
                  ],
                ),
              ),
            ),
          ),
        )
      ],
    ));
  }

  _fieldFocusChange(
      BuildContext context, FocusNode currentFocus, FocusNode nextFocus) {
    currentFocus.unfocus();
    FocusScope.of(context).requestFocus(nextFocus);
  }
}

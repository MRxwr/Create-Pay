import 'dart:async';

import 'package:clipboard_manager/clipboard_manager.dart';
import 'package:create_pay/pages/createbill.dart';
import 'package:create_pay/pages/dashboard.dart';
import 'package:flutter/material.dart';
import 'package:flutter_share/flutter_share.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:shared_preferences/shared_preferences.dart';

import 'beziercontainer.dart';

class PaymentURL extends StatefulWidget {
  @override
  _PaymentURLState createState() => _PaymentURLState();
}

class _PaymentURLState extends State<PaymentURL> {
  final GlobalKey<ScaffoldState> _scaffoldKey = new GlobalKey<ScaffoldState>();
  String _url = '';

  @override
  void initState() {
    _getURLValue('paymenturl').then(updatename);
    super.initState();
  }

  _showInSnackBar(String value) {
    _scaffoldKey.currentState
        .showSnackBar(new SnackBar(content: new Text(value)));
  }

  Future<String> _getURLValue(String key) async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    //Return String
    String stringValue = prefs.getString(key);
    return stringValue;
  }

  Future<String> _share(String url) async {
    await FlutterShare.share(
      title: 'CreatePay',
      //text: 'Example share text',
      linkUrl: url,
      //chooserTitle: 'Example Chooser Title'
    );
  }

  Widget _backButton() {
    return InkWell(
      onTap: () {
        //Navigator.pop(context);
        Navigator.push(
            context, MaterialPageRoute(builder: (context) => DashboardPage()));
      },
      child: Container(
        padding: EdgeInsets.symmetric(horizontal: 10),
        child: Row(
          children: <Widget>[
            Container(
              padding: EdgeInsets.only(left: 0, top: 10, bottom: 10),
              child: Icon(Icons.keyboard_arrow_left, color: Colors.black),
            ),
            Text('Back',
                style: TextStyle(fontSize: 12, fontWeight: FontWeight.w500))
          ],
        ),
      ),
    );
  }

  Widget _title() {
    return Center(
      child: Image(
        width: 180,
        image: AssetImage('assets/create_pay_logo_blue.png'),
        //image: NetworkImage(
        //    'https://flutter.dev/assets/flutter-lockup-1caf6476beed76adec3c477586da54de6b552b2f42108ec5bc68dc63bae2df75.png'),
      ),
    );
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
          Text("Payment URL: ",
              style: TextStyle(fontWeight: FontWeight.normal)),
          Text('$_url',
              style: TextStyle(
                  fontWeight: FontWeight.bold,
                  backgroundColor: Colors.grey[300])),
          SizedBox(
            height: 30,
          ),

          Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Align(
                alignment: Alignment.center,
              ),
              Row(
                crossAxisAlignment: CrossAxisAlignment.center,
                mainAxisAlignment: MainAxisAlignment.center,
                children: [
                  RaisedButton.icon(
                    textColor: Colors.white,
                    color: Color(0xff297bb2),
                    onPressed: () => {
                      ClipboardManager.copyToClipBoard('$_url').then((result) {
                        _showInSnackBar("Copied to Clipboad.");
                      })
                    },
                    icon: Icon(Icons.copy, size: 20),
                    label: Text("Copy URL",
                        style: TextStyle(
                            fontSize: 16, fontWeight: FontWeight.w500)),
                  ),
                  SizedBox(
                    width: 10,
                  ),
                  RaisedButton.icon(
                    textColor: Colors.white,
                    color: Color(0xff297bb2),
                    onPressed: () => _share('$_url'),
                    icon: Icon(Icons.share, size: 20),
                    label: Text("Share",
                        style: TextStyle(
                            fontSize: 16, fontWeight: FontWeight.w500)),
                  ),
                ],
              ),
            ],
          ),

          // SizedBox(
          //   height: 30,
          // ),
          // Column(
          //   mainAxisAlignment: MainAxisAlignment.center,
          //   children: [
          //     Align(
          //       alignment: Alignment.center,
          //     ),

          //     RaisedButton.icon(
          //       textColor: Colors.white,
          //       color: Color(0xff297bb2),
          //       onPressed: () => {
          //         Navigator.push(
          //           context,
          //           MaterialPageRoute(builder: (context) => CreateBill()),
          //         )
          //       },
          //       icon: Icon(Icons.create, size: 20),
          //       label: Text("Create Bill",
          //           style:
          //               TextStyle(fontSize: 16, fontWeight: FontWeight.w500)),
          //     ),
          //   ],
          // ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    final height = MediaQuery.of(context).size.height;
    return Scaffold(
        key: _scaffoldKey,
        body: Column(
          children: <Widget>[
            Expanded(
              flex: 1,
              child: Container(
                height: height,
                child: Stack(
                  children: [
                    Positioned(top: 40, left: 0, child: _backButton()),
                    Positioned(
                        bottom: 0,
                        left: 0,
                        right: 0,
                        child: Center(child: _title())),
                    Positioned(
                        top: -height * .15,
                        right: -MediaQuery.of(context).size.width * .4,
                        child: BezierContainer()),
                  ],
                ),
              ),
            ),
            Expanded(
              flex: 3,
              child: Container(
                //color: Colors.amber,
                width: double.infinity,
                padding: EdgeInsets.symmetric(horizontal: 20),
                child: SingleChildScrollView(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.center,
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: <Widget>[
                      Container(
                        padding: EdgeInsets.symmetric(vertical: 10),
                        alignment: Alignment.center,
                        child: Text('Payment URL',
                            style: TextStyle(
                                fontSize: 18, fontWeight: FontWeight.w500)),
                      ),
                      _displayDetails(),
                    ],
                  ),
                ),
              ),
            )
          ],
        ));
  }

  void updatename(String url) {
    setState(() {
      this._url = url;
    });
  }
}

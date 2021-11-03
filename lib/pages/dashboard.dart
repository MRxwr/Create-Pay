import 'package:create_pay/pages/beziercontainer.dart';
import 'package:create_pay/pages/changepassword.dart';
import 'package:create_pay/pages/createbill.dart';
import 'package:create_pay/pages/displayinvoice.dart';
import 'package:create_pay/pages/login.dart';
import 'package:create_pay/pages/privacy.dart';
import 'package:flutter/material.dart';
import 'dart:async';
import 'package:http/http.dart' as http;
import 'package:create_pay/models/InvoiceList.Dart';
import 'package:localize_and_translate/localize_and_translate.dart';
import 'package:shared_preferences/shared_preferences.dart';

import '../main.dart';

class DashboardPage extends StatefulWidget {
  DashboardPage({Key key, this.title}) : super(key: key);

  final String title;
  @override
  _DashboardPageState createState() => _DashboardPageState();
}

class _DashboardPageState extends State<DashboardPage> {
  //List data;
  InvoiceList data;

  _getURLValue(String key) async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String stringValue = prefs.getString(key);
    print(stringValue);
    return stringValue;
  }

  // @override
  // void initState() {
  //   super.initState();

  //   String ref = _getURLValue('reference');
  //   if (ref.isEmpty) {
  //     print("not logged in, going to login page");
  //     Navigator.push(
  //         context, MaterialPageRoute(builder: (context) => LoginPage()));
  //   }
  // }

  Widget _changePasswordButton() {
    return InkWell(
      onTap: () {
        Navigator.push(
            context, MaterialPageRoute(builder: (context) => ChangePassword()));
      },
      child: Container(
        padding: EdgeInsets.symmetric(horizontal: 10),
        child: Row(
          children: <Widget>[
            Container(
              padding: EdgeInsets.only(left: 0, top: 10, bottom: 10),
              child: Icon(Icons.edit_road_outlined, color: Colors.black),
            ),
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

  Future<InvoiceList> _fetchJobs() async {
    var reference = await _getURLValue('reference');
    print('Ref: ' + reference);
    String currentLang = translator.translate('langCode');
    var url = Uri.parse(
        "https://createpay.link/api/dashboard.php?refference=$reference&languageId=$currentLang");

    var response = await http.get(url, headers: {"Accept": "application/json"});

    if (response.statusCode == 200) {
      data = invoiceListFromJson(response.body);
      print(data);
      return data;
    } else {
      throw Exception('Failed to load jobs from API');
    }
  }

  ListView _jobsListView(data) {
    return ListView.builder(
      shrinkWrap: true,
      physics: NeverScrollableScrollPhysics(),
      padding: EdgeInsets.only(top: 0),
      itemBuilder: (context, index) {
        return Column(
          children: [
            titleSection(
                data.details.totalInvoicesTitle, data.details.totalInvoices),
            titleSection(data.details.totalPaidTitle, data.details.totalPaid),
            titleSection(
                data.details.totalPendingTitle, data.details.totalPending),
            titleSection(
                data.details.totalFailedTitle, data.details.totalFailed),
            titleSection(
                data.details.totalRefundedTitle, data.details.totalRefunded),
            titleSection(
                data.details.totalExpiredTitle, data.details.totalExpired),
            titleSection(
                data.details.earningsTitle, 'KD ' + data.details.earnings),
          ],
        );
      },
      itemCount: 1,
    );
  }

  showAlertDialog(BuildContext context) {
    // set up the buttons
    Widget cancelButton = FlatButton(
      child: Text(
        translator.translate('btnCancel'),
      ),
      onPressed: () {
        Navigator.of(context).pop();
      },
    );

    Widget continueButton = FlatButton(
      child: Text(
        translator.translate('textLogout'),
      ),
      onPressed: () {
        Navigator.push(
            context,
            MaterialPageRoute(
                builder: (context) => LoginPage(), fullscreenDialog: true));
      },
    );

    // set up the AlertDialog
    AlertDialog alert = AlertDialog(
      title: Text(
        translator.translate('textAlert'),
      ),
      content: Text(
        translator.translate('textAlertLogout'),
      ),
      actions: [
        cancelButton,
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

  Widget dashboardIcons() {
    final height = MediaQuery.of(context).size.height;
    return Container(
      height: height,
      color: Colors.red,
      padding: EdgeInsets.symmetric(vertical: 20.0, horizontal: 20.0),
      child: GridView.count(
        physics: NeverScrollableScrollPhysics(),
        primary: false,
        padding: const EdgeInsets.all(10),
        crossAxisSpacing: 10,
        mainAxisSpacing: 10,
        crossAxisCount: 2,
        children: <Widget>[
          // makeDashboardItem("Invoice List", Icons.receipt, ) ,

          Container(
            decoration: BoxDecoration(
                borderRadius: BorderRadius.circular(10),
                color: Color(0xff297bb2)),
            child: new InkWell(
              onTap: () {
                Navigator.push(context,
                    MaterialPageRoute(builder: (context) => DisplayInvoice()));
              },
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.stretch,
                mainAxisSize: MainAxisSize.min,
                verticalDirection: VerticalDirection.down,
                children: <Widget>[
                  SizedBox(height: 50.0),
                  Center(
                      child: Icon(
                    Icons.receipt,
                    size: 40.0,
                    color: Colors.white,
                  )),
                  SizedBox(height: 20.0),
                  new Center(
                    child: new Text('Invoice List',
                        style:
                            new TextStyle(fontSize: 16.0, color: Colors.white)),
                  )
                ],
              ),
            ),
          ),

          Container(
            decoration: BoxDecoration(
                borderRadius: BorderRadius.circular(10),
                color: Color(0xff297bb2)),
            child: new InkWell(
              onTap: () {
                Navigator.push(context,
                    MaterialPageRoute(builder: (context) => CreateBill()));
              },
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.stretch,
                mainAxisSize: MainAxisSize.min,
                verticalDirection: VerticalDirection.down,
                children: <Widget>[
                  SizedBox(height: 50.0),
                  Center(
                      child: Icon(
                    Icons.create,
                    size: 40.0,
                    color: Colors.white,
                  )),
                  SizedBox(height: 20.0),
                  new Center(
                    child: new Text('Create Invoice',
                        style:
                            new TextStyle(fontSize: 16.0, color: Colors.white)),
                  )
                ],
              ),
            ),
          ),

          Container(
            decoration: BoxDecoration(
                borderRadius: BorderRadius.circular(10),
                color: Color(0xff297bb2)),
            child: new InkWell(
              onTap: () {
                Navigator.push(context,
                    MaterialPageRoute(builder: (context) => PrivacyPage()));
              },
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.stretch,
                mainAxisSize: MainAxisSize.min,
                verticalDirection: VerticalDirection.down,
                children: <Widget>[
                  SizedBox(height: 50.0),
                  Center(
                      child: Icon(
                    Icons.update,
                    size: 40.0,
                    color: Colors.white,
                  )),
                  SizedBox(height: 20.0),
                  new Center(
                    child: new Text('Privacy Policy',
                        style:
                            new TextStyle(fontSize: 16.0, color: Colors.white)),
                  )
                ],
              ),
            ),
          ),

          Container(
            decoration: BoxDecoration(
                borderRadius: BorderRadius.circular(10),
                color: Color(0xff297bb2)),
            child: new InkWell(
              onTap: () {
                showAlertDialog(context);

                // Navigator.push(context,
                //     MaterialPageRoute(builder: (context) => LoginPage()));
              },
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.stretch,
                mainAxisSize: MainAxisSize.min,
                verticalDirection: VerticalDirection.down,
                children: <Widget>[
                  SizedBox(height: 50.0),
                  Center(
                      child: Icon(
                    Icons.logout,
                    size: 40.0,
                    color: Colors.white,
                  )),
                  SizedBox(height: 20.0),
                  new Center(
                    child: new Text('Logout',
                        style:
                            new TextStyle(fontSize: 16.0, color: Colors.white)),
                  )
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _dashboardIcons() {
    return SingleChildScrollView(
      child: Column(
        children: <Widget>[
          Row(
            children: <Widget>[
              Expanded(
                child: Padding(
                  padding: const EdgeInsets.all(10.0),
                  child: AspectRatio(
                    aspectRatio: 1.0,
                    child: Container(
                      decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(10),
                          color: Color(0xff297bb2)),
                      child: new InkWell(
                        onTap: () {
                          Navigator.push(
                              context,
                              MaterialPageRoute(
                                  builder: (context) => DisplayInvoice()));
                        },
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.stretch,
                          mainAxisSize: MainAxisSize.min,
                          verticalDirection: VerticalDirection.down,
                          children: <Widget>[
                            SizedBox(height: 50.0),
                            Center(
                                child: Icon(
                              Icons.receipt,
                              size: 40.0,
                              color: Colors.white,
                            )),
                            SizedBox(height: 20.0),
                            new Center(
                              child: new Text(
                                  translator.translate('textInvoiceList'),
                                  style: new TextStyle(
                                      fontSize: 16.0, color: Colors.white)),
                            )
                          ],
                        ),
                      ),
                    ),
                  ),
                ),
              ),
              Expanded(
                child: Padding(
                  padding: const EdgeInsets.all(10.0),
                  child: AspectRatio(
                    aspectRatio: 1.0,
                    child: Container(
                      decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(10),
                          color: Color(0xff297bb2)),
                      child: new InkWell(
                        onTap: () {
                          Navigator.push(
                              context,
                              MaterialPageRoute(
                                  builder: (context) => CreateBill()));
                        },
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.stretch,
                          mainAxisSize: MainAxisSize.min,
                          verticalDirection: VerticalDirection.down,
                          children: <Widget>[
                            SizedBox(height: 50.0),
                            Center(
                                child: Icon(
                              Icons.create,
                              size: 40.0,
                              color: Colors.white,
                            )),
                            SizedBox(height: 20.0),
                            new Center(
                              child: new Text(
                                  translator.translate('textCreateInvoice'),
                                  style: new TextStyle(
                                      fontSize: 16.0, color: Colors.white)),
                            )
                          ],
                        ),
                      ),
                    ),
                  ),
                ),
              ),
            ],
          ),
          Row(
            children: <Widget>[
              Expanded(
                child: Padding(
                  padding: const EdgeInsets.all(10.0),
                  child: AspectRatio(
                    aspectRatio: 1.0,
                    child: Container(
                      decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(10),
                          color: Color(0xff297bb2)),
                      child: new InkWell(
                        onTap: () {
                          Navigator.push(
                              context,
                              MaterialPageRoute(
                                  builder: (context) => PrivacyPage()));
                        },
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.stretch,
                          mainAxisSize: MainAxisSize.min,
                          verticalDirection: VerticalDirection.down,
                          children: <Widget>[
                            SizedBox(height: 50.0),
                            Center(
                                child: Icon(
                              Icons.update,
                              size: 40.0,
                              color: Colors.white,
                            )),
                            SizedBox(height: 20.0),
                            new Center(
                              child: new Text(
                                  translator.translate('textPrivacyPolicy'),
                                  style: new TextStyle(
                                      fontSize: 16.0, color: Colors.white)),
                            )
                          ],
                        ),
                      ),
                    ),
                  ),
                ),
              ),
              Expanded(
                child: Padding(
                  padding: const EdgeInsets.all(10.0),
                  child: AspectRatio(
                    aspectRatio: 1.0,
                    child: Container(
                      decoration: BoxDecoration(
                          borderRadius: BorderRadius.circular(10),
                          color: Color(0xff297bb2)),
                      child: new InkWell(
                        onTap: () {
                          showAlertDialog(context);

                          // Navigator.push(
                          //     context,
                          //     MaterialPageRoute(
                          //         builder: (context) => LoginPage()));
                        },
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.stretch,
                          mainAxisSize: MainAxisSize.min,
                          verticalDirection: VerticalDirection.down,
                          children: <Widget>[
                            SizedBox(height: 50.0),
                            Center(
                                child: Icon(
                              Icons.logout,
                              size: 40.0,
                              color: Colors.white,
                            )),
                            SizedBox(height: 20.0),
                            new Center(
                              child: new Text(
                                  translator.translate('textLogout'),
                                  style: new TextStyle(
                                      fontSize: 16.0, color: Colors.white)),
                            )
                          ],
                        ),
                      ),
                    ),
                  ),
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }

  Card makeDashboardItem(String title, IconData icon) {
    return Card(
        elevation: 1.0,
        margin: new EdgeInsets.all(8.0),
        child: Container(
          decoration: BoxDecoration(color: Color.fromRGBO(220, 220, 220, 1.0)),
          child: new InkWell(
            onTap: () {
              Navigator.push(context,
                  MaterialPageRoute(builder: (context) => LoginPage()));
            },
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.stretch,
              mainAxisSize: MainAxisSize.min,
              verticalDirection: VerticalDirection.down,
              children: <Widget>[
                SizedBox(height: 50.0),
                Center(
                    child: Icon(
                  icon,
                  size: 40.0,
                  color: Colors.black,
                )),
                SizedBox(height: 20.0),
                new Center(
                  child: new Text(title,
                      style:
                          new TextStyle(fontSize: 18.0, color: Colors.black)),
                )
              ],
            ),
          ),
        ));
  }

  Widget _buildCard() => FutureBuilder<InvoiceList>(
        future: _fetchJobs(),
        builder: (context, snapshot) {
          if (snapshot.hasData) {
            InvoiceList data = snapshot.data;
            return _jobsListView(data);
          } else if (snapshot.hasError) {
            return Text("${snapshot.error}");
          }
          return new Column(
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
          );
        },
      );

  Widget buildCard() => Container(
        //color: Colors.transparent,
        child: Column(
          children: [
            Expanded(
              child: FutureBuilder<InvoiceList>(
                future: _fetchJobs(),
                builder: (context, snapshot) {
                  if (snapshot.hasData) {
                    InvoiceList data = snapshot.data;
                    return _jobsListView(data);
                  } else if (snapshot.hasError) {
                    return Text("${snapshot.error}");
                  }
                  return new Column(
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
                  );
                },
              ),
            ),
          ],
        ),
      );

  Widget titleSection(String title, String total) => Container(
        padding: const EdgeInsets.all(12),
        child: Row(
          children: [
            Expanded(
              /*1*/
              child: Row(
                crossAxisAlignment: CrossAxisAlignment.center,
                mainAxisAlignment: MainAxisAlignment.start,
                children: [
                  Icon(
                    Icons.label,
                    color: Color(0xff297bb2),
                  ),
                  Text(
                    title,
                    style: TextStyle(fontSize: 16),
                  ),
                ],
              ),
            ),
            Text(total),
          ],
        ),
      );

  @override
  Widget build(BuildContext context) {
    final height = MediaQuery.of(context).size.height;
    return WillPopScope(
      onWillPop: () async => false,
      child: Scaffold(
          body: Column(
        children: <Widget>[
          Container(
            height: (MediaQuery.of(context).size.height / 4) + 30,
            child: Stack(
              children: [
                Positioned(
                    bottom: 10,
                    left: 0,
                    right: 0,
                    child: Center(child: _title())),
                Positioned(
                    top: -height * .15,
                    right: -MediaQuery.of(context).size.width * .4,
                    child: BezierContainer()),
                Positioned(top: 40, left: 0, child: _changePasswordButton()),
              ],
            ),
          ),
          Expanded(
            flex: 1,
            child: Container(
              //color: Colors.amber,
              width: double.infinity,
              padding: EdgeInsets.symmetric(horizontal: 20),
              child: SingleChildScrollView(
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.center,
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: <Widget>[
                    SizedBox(height: height * .01),
                    _dashboardIcons(),
                    SizedBox(height: 10),
                    Column(
                      children: [
                        _buildCard(),
                      ],
                    ),
                    SizedBox(height: 60),
                  ],
                ),
              ),
            ),
          )
        ],
      )),
    );
  }
}

// InvoiceStatus = 0 (pending),
// InvoiceStatus = 1 (Expired),
// InvoiceStatus = 2 (paid),
// InvoiceStatus = 3 (failed),

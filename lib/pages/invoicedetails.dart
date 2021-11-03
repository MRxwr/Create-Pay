import 'dart:convert';
import 'package:clipboard_manager/clipboard_manager.dart';
import 'package:create_pay/models/RefundModel.dart';
import 'package:flutter/material.dart';
import 'package:create_pay/models/InvoicesList.Dart';
import 'package:flutter_share/flutter_share.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:intl/intl.dart';
import 'package:localize_and_translate/localize_and_translate.dart';
import 'beziercontainer.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:async';
import 'package:http/http.dart' as http;
import 'dashboard.dart';
import 'dart:math' as math;

class InvoiceDetails extends StatefulWidget {
  final Invoice data;
  const InvoiceDetails({Key key, this.data}) : super(key: key);

  @override
  _InvoiceDetailsState createState() => _InvoiceDetailsState();
}

class _InvoiceDetailsState extends State<InvoiceDetails> {
  //final _formKey = GlobalKey<FormState>();
  final GlobalKey<ScaffoldState> _scaffoldKey = new GlobalKey<ScaffoldState>();

  Invoice get data => data;
  Color barColor = const Color(0xff297bb2);
  String _url = '';

  bool _load = false;

  // @override
  // void initState() {
  //   super.initState();
  // }

  // @override
  // void initState() {
  //   _getURLValue('paymenturl').then(updatename);
  //   super.initState();
  // }

  // void updatename(String url) {
  //   setState(() {
  //     this._url = url;
  //   });
  // }

  _showInSnackBar(String value) {
    _scaffoldKey.currentState
        .showSnackBar(new SnackBar(content: new Text(value)));
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

  Widget _status(String status) {
    int statuscode = int.parse(status);
    if (statuscode == 0) {
      barColor = const Color(0xffe1cf01); //Yellow
      return Text(translator.translate('textPending'));
    } else if (statuscode == 2) {
      barColor = const Color(0xffff0000); //Red
      return Text(translator.translate('textFailed'));
    } else if (statuscode == 1) {
      barColor = const Color(0xff176300); //Green
      return Text(translator.translate('textPaid'),
          style: new TextStyle(fontWeight: FontWeight.bold));
    } else if (statuscode == 3) {
      barColor = const Color(0xff002fb5); //Blue
      return Text(translator.translate('textRefund'),
          style: new TextStyle(fontWeight: FontWeight.bold));
    } else if (statuscode == 4) {
      barColor = const Color(0xff002fb5); //Purple
      return Text(translator.translate('textExpired'),
          style: new TextStyle(fontWeight: FontWeight.bold));
    } else {
      barColor = const Color(0xff297bb2);
      return Text('Unknown');
    }
  }

  Color _colorCode(String status) {
    int statuscode = int.parse(status);
    if (statuscode == 0) {
      return const Color(0xffe1cf01);
    } else if (statuscode == 2) {
      return const Color(0xffff0000);
    } else if (statuscode == 1) {
      return const Color(0xff176300);
    } else if (statuscode == 3) {
      return const Color(0xff002fb5);
    } else if (statuscode == 4) {
      return const Color(0xff7e3ab0);
    } else {
      return const Color(0xffe1cf01);
    }
  }

  Widget _displayDetails() {
    return Card(
      elevation: 2,
      shape: Border(
          left: BorderSide(
              color: _colorCode(widget.data.invoiceStatus), width: 6)),
      child: Container(
        padding: const EdgeInsets.all(18.0),
        alignment: Alignment.center,
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Align(
              alignment: Alignment.centerLeft,
            ),
            SizedBox(
              height: 20,
            ),
            Text(translator.translate('textInvoiceID'),
                style: TextStyle(fontWeight: FontWeight.normal)),
            Text(widget.data.orderId,
                style: TextStyle(fontWeight: FontWeight.bold)),
            SizedBox(
              height: 30,
            ),
            Text(translator.translate('textDate'),
                style: TextStyle(fontWeight: FontWeight.normal)),
            Text(
                "${DateFormat('dd/MM/yyyy').format(widget.data.date).toString()}",
                style: TextStyle(fontWeight: FontWeight.bold)),
            SizedBox(
              height: 20,
            ),
            Text(translator.translate('textName'),
                style: TextStyle(fontWeight: FontWeight.normal)),
            Text(widget.data.customerName,
                style: TextStyle(fontWeight: FontWeight.bold)),
            SizedBox(
              height: 20,
            ),
            Text(translator.translate('textMobile'),
                style: TextStyle(fontWeight: FontWeight.normal)),
            Text(widget.data.customerMobile,
                style: TextStyle(fontWeight: FontWeight.bold)),
            SizedBox(
              height: 20,
            ),
            Text(translator.translate('textEmail'),
                style: TextStyle(fontWeight: FontWeight.normal)),
            Text(widget.data.customerEmail,
                style: TextStyle(fontWeight: FontWeight.bold)),

            SizedBox(
              height: 20,
            ),
            Text(translator.translate('textDetails'),
                style: TextStyle(fontWeight: FontWeight.normal)),
            Text(widget.data.invoiceDetails,
                style: TextStyle(fontWeight: FontWeight.bold)),

            SizedBox(
              height: 20,
            ),
            Text(translator.translate('textAmount'),
                style: TextStyle(fontWeight: FontWeight.normal)),
            Text(widget.data.invoicePrice + ' KD',
                style: TextStyle(fontWeight: FontWeight.bold)),
            SizedBox(
              height: 20,
            ),
            Text(translator.translate('textStatus'),
                style: TextStyle(fontWeight: FontWeight.normal)),
            _status(widget.data.invoiceStatus)
            // Text(widget.data.invoiceStatus,
            //  style: TextStyle(fontWeight: FontWeight.bold)),
          ],
        ),
      ),
    );
  }

  _getURLValue(String key) async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String stringValue = prefs.getString(key);
    print(stringValue);
    return stringValue;
  }

  Future<http.Response> _refundJobs(String orderID) async {
    String currentLang = translator.translate('langCode');
    var url = Uri.parse(
        'https://createpay.link/api/refund.php?languageId=$currentLang');
    var reference = await _getURLValue('reference');
    var invoiceid = widget.data.orderId;

    print(reference);
    print(invoiceid);

    //invoiceId, refference

    Map<String, String> body = {
      'APPKEY': 'API123',
      'invoiceId': invoiceid,
      'refference': reference,
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

      final responseJson = refundModelFromJson(response.body);
      if (responseJson.isSuccess == true) {
        showAlertDialog(context, responseJson.message);
      } else {
        print("error");
        _showInSnackBar("please contact customer service");
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

  Widget _displayActions(int statuscode) {
    if (statuscode == 0) {
      return Container(
        child: Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            RaisedButton.icon(
              textColor: Colors.white,
              color: Color(0xff297bb2),
              onPressed: () {
                ClipboardManager.copyToClipBoard(widget.data.link)
                    .then((result) {
                  _showInSnackBar("Copied to Clipboad.");
                });
              },
              icon: Icon(Icons.copy, size: 20),
              label: Text("Copy",
                  style: TextStyle(fontSize: 16, fontWeight: FontWeight.w500)),
            ),
            SizedBox(width: 20),
            RaisedButton.icon(
              textColor: Colors.white,
              color: Color(0xff297bb2),
              onPressed: () => _share(widget.data.link),
              icon: Icon(Icons.share, size: 20),
              label: Text("Share",
                  style: TextStyle(fontSize: 16, fontWeight: FontWeight.w500)),
            ),
          ],
        ),
      );
    } else if (statuscode == 1) {
      return Container(
        child: Column(
          children: [
            RaisedButton.icon(
              textColor: Colors.white,
              color: Color(0xff297bb2),
              onPressed: () {
                setState(() {
                  showAlertDialogSubmit(context, widget.data.orderId);

                  //_refundJobs(widget.data.orderId);
                });
              },
              icon: Icon(Icons.payment, size: 20),
              label: Text(translator.translate('btnRefund'),
                  style: TextStyle(fontSize: 16, fontWeight: FontWeight.w500)),
            ),
          ],
        ),
      );
    } else if (statuscode == 2) {
      return Container(
        child: Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            RaisedButton.icon(
              textColor: Colors.white,
              color: Color(0xff297bb2),
              onPressed: () {
                ClipboardManager.copyToClipBoard(widget.data.link)
                    .then((result) {
                  _showInSnackBar("Copied to Clipboad.");
                });
              },
              icon: Icon(Icons.copy, size: 20),
              label: Text("Copy",
                  style: TextStyle(fontSize: 16, fontWeight: FontWeight.w500)),
            ),
            SizedBox(width: 20),
            RaisedButton.icon(
              textColor: Colors.white,
              color: Color(0xff297bb2),
              onPressed: () => _share(widget.data.link),
              icon: Icon(Icons.share, size: 20),
              label: Text("Share",
                  style: TextStyle(fontSize: 16, fontWeight: FontWeight.w500)),
            ),
          ],
        ),
      );
    } else {
      return Container(
        child: Column(),
      );
    }
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
                builder: (context) => DashboardPage(), fullscreenDialog: true));
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

  showAlertDialogSubmit(BuildContext context, String orderID) {
    // set up the buttons
    Widget cancelButton = TextButton(
      child: Text(
        translator.translate('btnNo'),
      ),
      onPressed: () {
        Navigator.of(context).pop();
      },
    );

    Widget continueButton = TextButton(
      child: Text(
        translator.translate('btnYes'),
      ),
      onPressed: () {
        Navigator.of(context).pop();
        _load = true;
        _refundJobs(orderID);
      },
    );

    // set up the AlertDialog
    AlertDialog alert = AlertDialog(
      title: Text(
        translator.translate('textAlert'),
      ),
      content: Text(
        translator.translate('textAlertRefund'),
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

  @override
  Widget build(BuildContext context) {
    int statuscode = int.parse(widget.data.invoiceStatus);

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
            body: Column(
              children: <Widget>[
                Expanded(
                  flex: 1,
                  child: Container(
                    height: height,
                    child: Stack(
                      children: [
                        Positioned(
                            top: -height * .15,
                            right: -MediaQuery.of(context).size.width * .4,
                            child: BezierContainer()),
                        Positioned.directional(
                            textDirection: Directionality.of(context),
                            top: 40,
                            child: _backButton()),
                        Positioned(
                            bottom: 0,
                            left: 0,
                            right: 0,
                            child: Center(child: _title())),
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
                          SizedBox(height: 20),
                          Text(translator.translate('textInvoiceDetails'),
                              style: new TextStyle(
                                  fontWeight: FontWeight.bold, fontSize: 21)),
                          SizedBox(height: 20),
                          _displayDetails(),
                          SizedBox(height: 20),
                          //Text(statuscode.toString()),
                          _displayActions(statuscode),
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
            )));
  }
}

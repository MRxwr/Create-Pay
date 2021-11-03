import 'package:create_pay/pages/invoicedetails.dart';
import 'package:flutter/material.dart';
import 'dart:async';
import 'package:http/http.dart' as http;
import 'package:create_pay/models/InvoicesList.Dart';
import 'package:intl/intl.dart';
import 'package:localize_and_translate/localize_and_translate.dart';
import 'beziercontainer.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:math' as math;
import 'package:create_pay/helpers/header_screen.dart';

import 'dashboard.dart';

class DisplayInvoice extends StatefulWidget {
  @override
  _DisplayInvoiceState createState() => _DisplayInvoiceState();
}

class _DisplayInvoiceState extends State<DisplayInvoice> {
  //List data;
  InvoicesList data;

  Color barColor = const Color(0xff297bb2);

  Widget _backButton() {
    return InkWell(
      onTap: () {
        Navigator.push(
            context, MaterialPageRoute(builder: (context) => DashboardPage()));
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
      ),
    );
  }

  _getURLValue(String key) async {
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String stringValue = prefs.getString(key);
    print(stringValue);
    return stringValue;
  }

  Widget _status(String status) {
    int statuscode = int.parse(status);
    if (statuscode == 0) {
      barColor = const Color(0xffe1cf01); //Yellow
      return Text(translator.translate('textPending'),
          style: new TextStyle(
              fontWeight: FontWeight.bold, color: Color(0xffe1cf01)));
    } else if (statuscode == 2) {
      barColor = const Color(0xffff0000); //Red
      return Text(translator.translate('textFailed'),
          style: new TextStyle(
              fontWeight: FontWeight.bold, color: Color(0xffff0000)));
    } else if (statuscode == 1) {
      barColor = const Color(0xff176300); //Green
      return Text(translator.translate('textPaid'),
          style: new TextStyle(
              fontWeight: FontWeight.bold, color: Color(0xff176300)));
    } else if (statuscode == 3) {
      barColor = const Color(0xff002fb5); //Blue
      return Text(translator.translate('textRefundList'),
          style: new TextStyle(
              fontWeight: FontWeight.bold, color: Color(0xff002fb5)));
    } else if (statuscode == 4) {
      barColor = const Color(0xff002fb5); //Purple
      return Text(translator.translate('textExpired'),
          style: new TextStyle(
              fontWeight: FontWeight.bold, color: Color(0xff7e3ab0)));

      // } else if (statuscode == 3) {
      //   barColor = const Color(0xff297bb2);
      //   return Text('Failed');
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

  Future<InvoicesList> _fetchJobs() async {
    var reference = await _getURLValue('reference');
    print('Ref: ' + reference);
    String currentLang = translator.translate('langCode');
    var response = await http.get(
        Uri.parse(
            'https://createpay.link/api/InvoicesList.php?refference=$reference&languageId=$currentLang'),
        headers: {"Accept": "application/json"});

    if (response.statusCode == 200) {
      final responseJson = invoicesListFromJson(response.body);

      print(responseJson.status);

      if (responseJson.status == 200) {
        data = invoicesListFromJson(response.body);
      }

      print(data);
      return data;
    } else {
      throw Exception('Failed to load jobs from API');
    }
  }

  ListView _jobsListView(data) {
    return ListView.builder(
      physics: ScrollPhysics(),
      itemBuilder: (context, index) {
        return Card(
          elevation: 3,
          shape: Border(
              left: BorderSide(
                  color: _colorCode(data.details.invoices[index].invoiceStatus),
                  width: 6)),
          child: InkWell(
            child: Padding(
              padding: const EdgeInsets.all(16.0),
              child: Column(
                children: [
                  Row(
                    children: [
                      //Icon(Icons.today),
                      Text(translator.translate('textDate')),
                      Text(
                          "${DateFormat('dd/MM/yyyy').format(data.details.invoices[index].date).toString()}"),
                      Spacer(),
                    ],
                  ),
                  Row(
                    children: [
                      Text(translator.translate('textName')),
                      Text(data.details.invoices[index].customerName),
                      Spacer(),
                      Text(
                        translator.translate('KD') +
                            data.details.invoices[index].invoicePrice,
                        style: new TextStyle(fontSize: 14.0),
                      ),
                      Text(' | '),
                      _status(data.details.invoices[index].invoiceStatus)
                    ],
                  ),
                  Row(
                    children: [
                      Text(translator.translate('textMobile')),
                      Text(data.details.invoices[index].customerMobile),
                    ],
                  )
                ],
              ),
            ),
            onTap: () {
              print(data.details.invoices[index].customerName);
              Navigator.push(
                context,
                MaterialPageRoute(
                    builder: (context) =>
                        InvoiceDetails(data: data.details.invoices[index])),
              );
            },
          ),
        );
      },
      itemCount: data.details.invoices.length,
      shrinkWrap: true,
    );
  }

  Widget _buildCard() => FutureBuilder<InvoicesList>(
        future: _fetchJobs(),
        builder: (context, snapshot) {
          if (snapshot.hasData) {
            InvoicesList data = snapshot.data;
            return _jobsListView(data);
          } else if (snapshot.hasError) {
            return Text("${snapshot.error}"); //${snapshot.error}
          } else {
            return Text("No Data");
          }
          // return new Column(
          //   crossAxisAlignment: CrossAxisAlignment.center,
          //   mainAxisAlignment: MainAxisAlignment.center,
          //   children: [
          //     new Center(
          //       child: new SizedBox(
          //         height: 50.0,
          //         width: 50.0,
          //         child: new CircularProgressIndicator(
          //           value: null,
          //           strokeWidth: 7.0,
          //         ),
          //       ),
          //     )
          //   ],
          // );
        },
      );

  Widget buildCard() => SizedBox(
        height: 400,
        child: Expanded(
          child: FutureBuilder<InvoicesList>(
            future: _fetchJobs(),
            builder: (context, snapshot) {
              if (snapshot.hasData) {
                InvoicesList data = snapshot.data;
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
      );

  Widget titleSection(String title, String total) => Container(
        padding: const EdgeInsets.all(12),
        child: Row(
          children: [
            Expanded(
              /*1*/
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  /*2*/
                  Container(
                    padding: const EdgeInsets.only(bottom: 8),
                    child: Text(
                      title,
                      style: TextStyle(
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                  ),
                  Text(
                    'Customer Name',
                    style: TextStyle(
                      color: Colors.grey[500],
                    ),
                  ),
                ],
              ),
            ),
            /*3*/
            Icon(
              Icons.star,
              color: Colors.red[500],
            ),
            Text(total),
          ],
        ),
      );

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
                  SizedBox(height: 20),
                  Text(translator.translate('textInvoiceList'),
                      style: new TextStyle(
                          fontWeight: FontWeight.bold, fontSize: 21)),
                  _buildCard(),
                ],
              ),
            ),
          ),
        )
      ],
    ));
  }
}

import 'package:create_pay/models/PrivacyModel.dart';
import 'package:flutter/material.dart';
import 'package:localize_and_translate/localize_and_translate.dart';
import 'dart:async';
import 'package:http/http.dart' as http;
import 'dart:math' as math;
import 'package:create_pay/helpers/header_screen.dart';
import 'dashboard.dart';

class PrivacyPage extends StatefulWidget {
  PrivacyPage() : super();

  @override
  PrivacyPageState createState() => PrivacyPageState();
}

class PrivacyPageState extends State<PrivacyPage> {
  Future<PrivacyModel> _fetchJobs() async {
    PrivacyModel data;
    String currentLang = translator.translate('langCode');
    var response = await http.get(
        Uri.parse(
            'https://createpay.link/api/policy.php?languageId=$currentLang'),
        headers: {"Accept": "application/json"});

    if (response.statusCode == 200) {
      data = privacyModelFromJson(response.body);
      print(data);
      return data;
    } else {
      throw Exception('Failed to load jobs from API');
    }
  }

  Widget _buildCard() => FutureBuilder<PrivacyModel>(
        future: _fetchJobs(),
        builder: (context, snapshot) {
          if (snapshot.hasData) {
            PrivacyModel data = snapshot.data;
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

  ListView _jobsListView(data) {
    return ListView.builder(
      shrinkWrap: true,
      physics: NeverScrollableScrollPhysics(),
      padding: EdgeInsets.only(top: 0),
      itemBuilder: (context, index) {
        return Column(
          children: [
            Text(data.details,
                style:
                    new TextStyle(fontWeight: FontWeight.normal, fontSize: 16),
                textAlign: TextAlign.justify),
          ],
        );
      },
      itemCount: 1,
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
          flex: 1,
          child: Container(
            //color: Colors.amber,
            width: double.infinity,
            padding: EdgeInsets.symmetric(horizontal: 20),
            child: SingleChildScrollView(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.center,
                mainAxisAlignment: MainAxisAlignment.start,
                children: <Widget>[
                  SizedBox(height: 20),
                  Text(translator.translate('textPrivacyPolicy'),
                      style: new TextStyle(
                          fontWeight: FontWeight.bold, fontSize: 21)),
                  SizedBox(height: 20),
                  _buildCard(),
                ],
              ),
            ),
          ),
        )
      ],
    ));
  }

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
}

import 'dart:convert';
import 'package:create_pay/pages/login.dart';
import 'package:create_pay/pages/signup.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import 'package:flutter/material.dart';
import 'package:localize_and_translate/localize_and_translate.dart';
import 'package:flutter/services.dart';
import 'dart:async';
import 'package:http/http.dart' as http;
import 'package:overlay_support/overlay_support.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'dart:io' show Platform;
import 'models/push_notification.dart';

main() async {
  // if your flutter > 1.7.8 :  ensure flutter activated
  WidgetsFlutterBinding.ensureInitialized();

  await translator.init(
    localeDefault: LocalizationDefaultType.device,
    languagesList: <String>['ar', 'en'],
    assetsDirectory: 'assets/langs/',
    apiKeyGoogle: '<Key>', // NOT YET TESTED
  ); // intialize

  WidgetsFlutterBinding.ensureInitialized();
  SystemChrome.setPreferredOrientations([
    DeviceOrientation.portraitUp,
    DeviceOrientation.portraitDown,
  ]);

  runApp(LocalizedApp(child: MyApp()));
}

PushNotification _notificationInfo;
int _totalNotifications;

class MyApp extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return OverlaySupport(
      child: MaterialApp(
        debugShowCheckedModeBanner: false,
        home: HomePage(),
        builder: (context, navigator) {
          var lang = Localizations.localeOf(context).languageCode;

          return Theme(
            data: ThemeData(fontFamily: lang == 'ar' ? 'Cairo' : 'Quicksand'),
            child: navigator,
          );
        },
        localizationsDelegates: translator.delegates,
        locale: translator.locale,
        supportedLocales: translator.locals(),
      ),
    );
  }
}

Future<dynamic> _firebaseMessagingBackgroundHandler(
  Map<String, dynamic> message,
) async {
  // Initialize the Firebase app
  await Firebase.initializeApp();
  print('onBackgroundMessage received: $message');
}

class HomePage extends StatefulWidget {
  HomePage({Key key, this.title}) : super(key: key);

  final String title;

  @override
  _HomePageState createState() => _HomePageState();
}

class _HomePageState extends State<HomePage> {
  FirebaseMessaging _messaging = FirebaseMessaging();

  void registerNotification() async {
    // Initialize the Firebase app
    await Firebase.initializeApp();

    // On iOS, this helps to take the user permissions
    await _messaging.requestNotificationPermissions(
      IosNotificationSettings(
        alert: true,
        badge: true,
        provisional: false,
        sound: true,
      ),
    );

    // For handling the received notifications
    _messaging.configure(
      onMessage: (message) async {
        print('onMessage received: $message');

        PushNotification notification = PushNotification.fromJson(message);

        print(notification.title);

        setState(() {
          _notificationInfo = notification;
          _totalNotifications++;
        });

        // For displaying the notification as an overlay
        showSimpleNotification(
          Text(_notificationInfo.title),
          //leading: NotificationBadge(totalNotifications: _totalNotifications),
          leading: CircleAvatar(
            backgroundImage: AssetImage('assets/icon.png'),
          ),
          subtitle: Text(_notificationInfo.body),
          background: Colors.lightBlue,
          duration: Duration(seconds: 4),
        );
      },
      onBackgroundMessage: _firebaseMessagingBackgroundHandler,
      onLaunch: (message) async {
        print('onLaunch: $message');

        PushNotification notification = PushNotification.fromJson(message);

        setState(() {
          _notificationInfo = notification;
          _totalNotifications++;
        });
      },
      onResume: (message) async {
        print('onResume: $message');

        PushNotification notification = PushNotification.fromJson(message);

        setState(() {
          _notificationInfo = notification;
          _totalNotifications++;
        });
      },
    );

    // Used to get the current FCM token
    _messaging.getToken().then((token) {
      print('Token: $token');
      setState(() {
        _saveTokenValue(token);
        _fetchJobs(token);
      });
    }).catchError((e) {
      print(e);
    });
  }

  @override
  void initState() {
    _totalNotifications = 0;
    registerNotification();
    super.initState();
  }

  // @override
  // Widget build(BuildContext context) {
  //   return Scaffold(
  //     appBar: AppBar(
  //       title: Text('Notify'),
  //       brightness: Brightness.dark,
  //     ),
  //     body: Column(
  //       mainAxisAlignment: MainAxisAlignment.center,
  //       children: [
  //         Text(
  //           'App for capturing Firebase Push Notifications',
  //           textAlign: TextAlign.center,
  //           style: TextStyle(
  //             color: Colors.black,
  //             fontSize: 20,
  //           ),
  //         ),
  //         SizedBox(height: 16.0),
  //         NotificationBadge(totalNotifications: _totalNotifications),
  //         SizedBox(height: 16.0),
  //         _notificationInfo != null
  //             ? Column(
  //                 crossAxisAlignment: CrossAxisAlignment.start,
  //                 children: [
  //                   Text(
  //                     'TITLE: ${_notificationInfo.title ?? _notificationInfo.dataTitle}',
  //                     style: TextStyle(
  //                       fontWeight: FontWeight.bold,
  //                       fontSize: 16.0,
  //                     ),
  //                   ),
  //                   SizedBox(height: 8.0),
  //                   Text(
  //                     'BODY: ${_notificationInfo.body ?? _notificationInfo.dataBody}',
  //                     style: TextStyle(
  //                       fontWeight: FontWeight.bold,
  //                       fontSize: 16.0,
  //                     ),
  //                   ),
  //                 ],
  //               )
  //             : Container(),
  //       ],
  //     ),
  //   );
  // }

  Widget _title() {
    return Center(
      child: Image(
        width: 160,
        image: AssetImage('assets/create_pay_logo.png'),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: SingleChildScrollView(
        child: Container(
          padding: EdgeInsets.symmetric(horizontal: 20),
          height: MediaQuery.of(context).size.height,
          decoration: BoxDecoration(
              borderRadius: BorderRadius.all(Radius.circular(5)),
              boxShadow: <BoxShadow>[
                BoxShadow(
                    color: Colors.grey.shade100,
                    offset: Offset(2, 4),
                    blurRadius: 5,
                    spreadRadius: 2)
              ],
              gradient: LinearGradient(
                  begin: Alignment.topCenter,
                  end: Alignment.bottomCenter,
                  colors: [
                    Colors.blue.withOpacity(.8),
                    Colors.blue[100].withOpacity(.8)
                  ])),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.center,
            mainAxisAlignment: MainAxisAlignment.center,
            children: <Widget>[
              _title(),
              SizedBox(
                height: 80,
              ),
              //_submitButton(),
              InkWell(
                onTap: () {
                  Navigator.push(context,
                      MaterialPageRoute(builder: (context) => LoginPage()));
                },
                child: Container(
                  width: MediaQuery.of(context).size.width,
                  padding: EdgeInsets.symmetric(vertical: 18),
                  alignment: Alignment.center,
                  decoration: BoxDecoration(
                      borderRadius: BorderRadius.all(Radius.circular(5)),
                      boxShadow: <BoxShadow>[
                        BoxShadow(
                          color: Colors.grey.withOpacity(0.5),
                          spreadRadius: 3,
                          blurRadius: 7,
                          offset: Offset(0, 3), // changes position of shadow
                        ),
                      ],
                      color: Colors.white),
                  child: Text(
                    translator.translate('textLogin'),
                    style: TextStyle(fontSize: 20, color: Colors.blue),
                  ),
                ),
              ),

              SizedBox(
                height: 20,
              ),
              //_signUpButton(),
              InkWell(
                onTap: () {
                  Navigator.push(context,
                      MaterialPageRoute(builder: (context) => SignUpPage()));
                },
                child: Container(
                  width: MediaQuery.of(context).size.width,
                  padding: EdgeInsets.symmetric(vertical: 13),
                  alignment: Alignment.center,
                  decoration: BoxDecoration(
                    borderRadius: BorderRadius.all(Radius.circular(5)),
                    border: Border.all(color: Colors.white, width: 2),
                  ),
                  child: Text(
                    translator.translate('textRegister'),
                    style: TextStyle(fontSize: 20, color: Colors.white),
                  ),
                ),
              ),

              SizedBox(
                height: 80,
              ),

              // _language()
              Text(
                translator.translate('textSwitchLanguage'),
                style: TextStyle(color: Colors.white, fontSize: 17),
              ),
              SizedBox(
                height: 20,
              ),
              FlatButton(
                color: Colors.white,
                onPressed: () {
                  translator.setNewLanguage(
                    context,
                    newLanguage:
                        translator.currentLanguage == 'ar' ? 'en' : 'ar',
                    remember: true,
                    restart: true,
                  );
                },
                child: Text(translator.translate('buttonTitle')),
              ),
            ],
          ),
        ),
      ),
    );
  }

  void _saveTokenValue(String token) async {
    SharedPreferences preferences = await SharedPreferences.getInstance();
    preferences.setString('token', token);
  }

  Future<http.Response> _fetchJobs(String token) async {
    var url = Uri.parse('https://createpay.link/api/firebase/newDevice.php');
    Map<String, String> body = {
      'APPKEY': 'API123',
      'token': token,
    };

    var response = await http.post(url,
        headers: <String, String>{
          'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
          'APPKEY': 'API123',
        },
        body: body);

    if (response.statusCode == 200) {
      final responseJson = jsonDecode(response.body);
      print(responseJson['msg']);
      print("token-success");
    } else {
      print("token-failed");
      throw Exception('Failed to load jobs from API');
    }
    return response;
  }
}

class NotificationBadge extends StatelessWidget {
  final int totalNotifications;

  const NotificationBadge({@required this.totalNotifications});

  @override
  Widget build(BuildContext context) {
    return Container(
      width: 40.0,
      height: 40.0,
      decoration: new BoxDecoration(
        color: Colors.red,
        shape: BoxShape.circle,
      ),
      child: Center(
        child: Padding(
          padding: const EdgeInsets.all(8.0),
          child: Text(
            '$totalNotifications',
            style: TextStyle(color: Colors.white, fontSize: 20),
          ),
        ),
      ),
    );
  }
}

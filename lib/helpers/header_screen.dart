import 'package:create_pay/pages/beziercontainer.dart';
import 'package:flutter/material.dart';
import 'package:localize_and_translate/localize_and_translate.dart';
import 'dart:math' as math;

class HeaderScreen extends StatelessWidget {
  Widget _backButton(BuildContext context) {
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
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    final height = MediaQuery.of(context).size.height;
    return Container(
        child: Stack(
      children: [
        Positioned(
            top: -height * .15,
            right: -MediaQuery.of(context).size.width * .4,
            child: BezierContainer()),
        Positioned.directional(
            textDirection: Directionality.of(context),
            top: 40,
            child: _backButton(context)),
        Positioned(
            bottom: 10, left: 0, right: 0, child: Center(child: _title())),
      ],
    ));
  }
}

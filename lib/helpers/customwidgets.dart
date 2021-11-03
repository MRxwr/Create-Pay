import 'package:flutter/material.dart';

class CustomWidgets extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Center(
      child: Image(
        width: 160,
        image: NetworkImage(
            'https://flutter.dev/assets/flutter-lockup-1caf6476beed76adec3c477586da54de6b552b2f42108ec5bc68dc63bae2df75.png'),
      ),
    );
  }
}

import 'dart:async';
import 'package:ex1/pages/onboarding_page.dart';
import 'package:flutter/material.dart';
import 'package:lottie/lottie.dart';




class MyLoadingPage extends StatefulWidget {
  const MyLoadingPage({super.key, required this.title});
  final String title;

  @override
  State<MyLoadingPage> createState() => _MyLoadingPageState();
}

class _MyLoadingPageState extends State<MyLoadingPage> {

  @override
  void initState() {
    super.initState();
    loadAnimation();
  }

  Future<Timer> loadAnimation() async {
    return Timer(
    const Duration(seconds: 3),
      onLoaded
    );
  }


  onLoaded() {
    Navigator.of(context).pushReplacement(
      MaterialPageRoute(
        builder: (context) => OnboardingPage(),
      ),
    );
  }


  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.black,
      body: Center(
        child: Lottie.asset(
          'assets/lotties/Cinephoria.json',
          repeat: true,
          reverse: false,
          animate: true,
        ),
      ),
    );
  }
}
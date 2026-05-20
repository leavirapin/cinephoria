import 'package:flutter/material.dart';
import 'package:qr_flutter/qr_flutter.dart';
import 'dart:convert';

class Qrcodepage extends StatelessWidget {
  const Qrcodepage({super.key, required this.seance});

  final Map<String, dynamic> seance;

  @override
  Widget build(BuildContext context) {
    final dataQR = jsonEncode({
      "idreservation": seance["idreservation"],
      "titre": seance["titre"],
      "date_heure": seance["date_heure"],
      "salle": seance["nom_salle"],
      "version": seance["version"],
      "nb_places": seance["nb_places"],
      "siege": seance["siege"],
    });

    return Scaffold(
      appBar: AppBar(
        title: const Text("Mon billet"),
        backgroundColor: Colors.black,
        foregroundColor: Colors.white,
      ),
      backgroundColor: Colors.black45,
      body: Padding(
        padding: const EdgeInsets.all(25.0),
        child: Column(
          children: [
            Row(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Image.asset(
                  "assets/images/image1.jpeg",
                  width: 100,
                ),
                const SizedBox(width: 20),
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        seance["titre"] ?? "",
                        style: const TextStyle(
                          color: Colors.white,
                          fontSize: 20,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                      Text(
                        seance["date_heure"] ?? "",
                        style: const TextStyle(
                          color: Color(0xFFC47938),
                          fontSize: 12,
                        ),
                      ),
                      Text(
                        "Salle : ${seance["nom_salle"] ?? ""}",
                        style: const TextStyle(
                          color: Color(0xFFC47938),
                          fontSize: 12,
                        ),
                      ),
                      Text(
                        "Version : ${seance["version"] ?? ""}",
                        style: const TextStyle(
                          color: Color(0xFFC47938),
                          fontSize: 12,
                        ),
                      ),
                      Text(
                        "Places : ${seance["nb_places"] ?? ""}",
                        style: const TextStyle(
                          color: Color(0xFFC47938),
                          fontSize: 12,
                        ),
                      ),
                      Text(
                        "Siège : ${seance["siege"] ?? ""}",
                        style: const TextStyle(
                          color: Color(0xFFC47938),
                          fontSize: 12,
                        ),
                      ),
                    ],
                  ),
                ),
              ],
            ),
            const SizedBox(height: 25),
            Center(
              child: QrImageView(
                size: 160,
                backgroundColor: Colors.white,
                data: dataQR,
              ),
            ),
          ],
        ),
      ),
    );
  }
}
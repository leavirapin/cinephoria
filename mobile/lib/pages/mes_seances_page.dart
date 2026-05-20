import 'package:flutter/material.dart';
import 'dart:convert';
import 'package:ex1/pages/qrcode_page.dart';
import 'package:http/http.dart' as http;

class MesSeancesPage extends StatefulWidget {
  final String idUtilisateur;

  const MesSeancesPage({
    super.key,
    required this.idUtilisateur,
  });

  @override
  State<MesSeancesPage> createState() => _MesSeancesPageState();
}

class _MesSeancesPageState extends State<MesSeancesPage> {
  List seances = [];
  bool isLoading = true;
  String messageErreur = "";

  void getSeances() async {
    final url = Uri.parse("http://localhost:8888/cine/api/mes_seances.php");

    final response = await http.post(
      url,
      body: {
        "id_utilisateur": widget.idUtilisateur,
      },
    );

    final data = jsonDecode(response.body);

    setState(() {
      isLoading = false;
    });

    if (data['success'] == true) {
      setState(() {
        seances = data["seances"];
      });
    } else {
      setState(() {
        messageErreur = data["message"];
      });
    }
  }

  @override
  void initState() {
    super.initState();
    getSeances();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text("Mes séances"),
        centerTitle: true,
        backgroundColor: Colors.black,
        foregroundColor: Colors.white,
      ),
      backgroundColor: Colors.black45,
      body: isLoading
          ? const Center(
        child: CircularProgressIndicator(),
      )
          : messageErreur.isNotEmpty
          ? Center(
        child: Text(
          messageErreur,
          style: const TextStyle(color: Colors.white),
        ),
      )
          : seances.isEmpty
          ? const Center(
        child: Text(
          "Aucune séance réservée",
          style: TextStyle(color: Colors.white),
        ),
      )
          : ListView.builder(
        itemCount: seances.length,
        itemBuilder: (context, index) {
          final seance = seances[index];

          return Card(
            color: Colors.blue,
            elevation: 6,
            margin: const EdgeInsets.symmetric(
              horizontal: 10,
              vertical: 9,
            ),
            shape: RoundedRectangleBorder(
              borderRadius: BorderRadius.circular(12),
            ),
            child: ListTile(
              leading: ClipRRect(
                borderRadius: BorderRadius.circular(5),
                child: Image.asset(
                  "assets/images/image1.jpeg",
                  height: 50,
                  width: 50,
                  fit: BoxFit.cover,
                ),
              ),
              title: Text(
                seance["titre"] ?? "",
                style: const TextStyle(
                  color: Colors.white,
                  fontSize: 20,
                  fontWeight: FontWeight.bold,
                ),
              ),
              subtitle: Text(
                "${seance["date_heure"] ?? ""} • Salle ${seance["nom_salle"] ?? ""} • ${seance["version"] ?? ""} • ${seance["nb_places"] ?? ""} place(s)",
                style: const TextStyle(
                  color: Colors.white70,
                ),
              ),
              onTap: () {
                Navigator.push(
                  context,
                  MaterialPageRoute(
                    builder: (context) => Qrcodepage(
                      seance: seance,
                    ),
                  ),
                );
              },
            ),
          );
        },
      ),
    );
  }
}
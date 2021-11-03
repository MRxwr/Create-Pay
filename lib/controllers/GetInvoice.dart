import 'package:http/http.dart' as http;
import 'package:create_pay/models/InvoiceList.Dart';

class GetInvoice {
  static const String url =
      "https://createpay.link/api/dashboard.php?refference=ref0008";

  static Future<InvoiceList> getInvoiceList() async {
    try {
      final response = await http.post(Uri.parse(
          "https://createpay.link/api/dashboard.php?refference=ref0008"));
      if (200 == response.statusCode) {
        final invoiceList = invoiceListFromJson(response.body);
        return invoiceList;
      } else {
        return InvoiceList();
      }
    } catch (e) {
      return InvoiceList();
    }
  }
}

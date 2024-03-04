//
//  ScannerViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 14/03/23.
//

import Foundation

class ScannerViewModel : Codable{
    // MARK: - Variable Initializer
    var ticketNo = String()
    // MARK: - Create function for scan QR Detail
    func callScannedOrderDetailApi(ticketNo: String,completition: @escaping(ScannerDetailModel, Bool) -> Void){
        let param: [String: Any] = [
            Scanner.ticket_no: ticketNo
        ]
        Webservice.service(api: .qrDetails,param: param,service: .get) { (model: ScannerDetailModel , data, json) in
            if model.statusCode == 200{
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
}

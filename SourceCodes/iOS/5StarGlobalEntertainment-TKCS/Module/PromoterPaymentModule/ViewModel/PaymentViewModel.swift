//
//  PaymentViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 13/04/23.
//

import Foundation

class PaymentViewModel : Codable{
    // MARK: - Create function for call update Cart API
    func callPromoterPaymentApi(userID: Int, amount: Int, eventID: Int, Striptoken: String, complition: @escaping(EventLivePaymentModel?, Bool)->Void){
        let param: [String: Any] = [
            "payable_amount": "$\(amount)",
            "event_id": eventID,
            "event_created_by": userID,
            "stripeToken" : Striptoken
            
        ]
        Webservice.service(api: .PayAmmount, param: param,service: .post) { (model: EventLivePaymentModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
}

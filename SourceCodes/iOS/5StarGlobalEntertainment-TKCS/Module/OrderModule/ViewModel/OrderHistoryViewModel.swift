//
//  OrderHistoryViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 29/03/23.
//

import Foundation
// MARK: - Create view model for order history
class OrderHistoryViewModel : Codable{
    // MARK: - Create function for call get subscriber user API
    func callOrderHistoryApi(completition: @escaping(OrderHistoryModel, Bool) -> Void){
        Webservice.service(api: .OrderHistory,service: .get) { (model: OrderHistoryModel , data, json) in
            if model.statusCode == 200{
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
    // MARK: - Create function for call get subscriber user API
    func callPayoutApi(completition: @escaping(PayoutModel, Bool) -> Void){
            Webservice.service(api: .Payout,service: .get) { (model: PayoutModel , data, json) in
                if model.statusCode == 200{
                    completition(model,true)
                }else{
                    completition(model,false)
                }
            }
        }
}

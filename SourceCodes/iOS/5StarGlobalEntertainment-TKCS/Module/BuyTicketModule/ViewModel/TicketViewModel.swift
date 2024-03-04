//
//  TicketViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 21/12/22.
//

import Foundation

class TicketViewModel: NSObject{
    // MARK: Create function For call Event Detail API--
    func CallTicketApi(eventId: Int ,completition: @escaping(TicketModel, Bool) -> Void){
        Webservice.service(api: .eventDetail,urlAppendId: eventId,service: .get) { (model: TicketModel , data, json) in
            if model.success ?? false{
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
    // MARK: Create function For call Add to cart API--
    func callAddToCartApi(ticketID: Int, quantity: Int, complition: @escaping(CartModel?, Bool)->Void){
        let param: [String: Any] = [
            AddToCartParam.userID : UserDefaults.standard.integer(forKey: DefaultValue.UserID.rawValue),
            AddToCartParam.ticketID : ticketID,
            AddToCartParam.quantity : quantity
        ]
        Webservice.service(api: .addToCart, param: param,service: .post) { (model: CartModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }    
}

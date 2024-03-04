//
//  CartViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 11/01/23.
//

import Foundation

class CartViewModel : NSObject{
    func callCheckOutApi(completition: @escaping(CartModelData, Bool) -> Void){
        Webservice.service(api: .checkout,service: .get) { (model: CartModelData , data, json) in
            if model.statusCode == 200{
              
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
   
    func callUpdateCartApi(userID: Int, ticketID: Int, quantity: Int, complition: @escaping(CartModelData?, Bool)->Void){
        let param: [String: Any] = [
            AddToCartParam.userID : userID,
            AddToCartParam.ticketID : ticketID,
            AddToCartParam.quantity : quantity
            
        ]
        Webservice.service(api: .checkout, param: param,service: .post) { (model: CartModelData, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
    
    func callDeleteCartApi(id: Int, complition: @escaping(DeleteCart?, Bool)->Void){
        Webservice.service(api: .deleteCartItem, urlAppendId: "/\(id)",service: .get) { (model: DeleteCart, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
}

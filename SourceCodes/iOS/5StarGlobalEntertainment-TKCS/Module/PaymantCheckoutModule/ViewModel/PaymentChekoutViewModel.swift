//
//  PaymentChekoutViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 20/02/23.
//

import Foundation

class PaymentCheckoutViewModel: NSObject{
    func OrderApi(userID: Int?,totalPrice: Int?,billingAddressId: Int?,fullName: String?,phoneNumber: String?,email:String?,state: String?, city: String?,zipcode: String?, address:String?,stripeToken: String?,cartItems:Int?, complition: @escaping(PlacedOrder?, Bool)->Void){
        
        let billingAddressParam: [String: Any] = [
            
            //  "active_address_id": 13,
            PlacedOrderParam.fullName : fullName ?? "",
            PlacedOrderParam.phoneNumber: phoneNumber ?? "",
            PlacedOrderParam.billingAddressId : billingAddressId ?? 0,
            PlacedOrderParam.email: email ?? "",
            PlacedOrderParam.state: state ?? "",
            PlacedOrderParam.city: city ?? "",
            PlacedOrderParam.zipcode:zipcode ?? "",
            PlacedOrderParam.address: address ?? ""
        ]
        let param: [String: Any] = [
            PlacedOrderParam.userId : userID ?? 0,
            PlacedOrderParam.cartItems: cartItems ?? 0,
            PlacedOrderParam.totalPrice : totalPrice ?? 0,
            PlacedOrderParam.stripeToken: stripeToken ?? "" ,
            "billing_address":billingAddressParam
        ]
        
        debugPrint(param)
        
        Webservice.service(api: .placeOrder, param: param,service: .post) { (model: PlacedOrder, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
}

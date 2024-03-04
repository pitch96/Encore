//
//  PaymentCheckoutViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 20/02/23.
//

import Foundation
class PaymentCheckoutViewModel: NSObject {
        

    // MARK: Create function for call Order API--
    func callOrderApi(userID: Int?,totalPrice: Int?, billingAddressId: Int?, fullName: String?, phoneNumber: String?, email:String?,state: String?, city: String?, zipcode: String?, address:String?, stripeToken: String?, cartItems:Int?, complition: @escaping(PlacedOrder?, Bool)->Void){
        
        var billingAddressParam: [String: Any] = [
            PlacedOrderParam.fullName : fullName ?? DefaultValue.emptyString.rawValue,
            PlacedOrderParam.phoneNumber: phoneNumber ?? DefaultValue.emptyString.rawValue,
            PlacedOrderParam.billingAddressId : billingAddressId ?? 0,
            PlacedOrderParam.email: email ?? DefaultValue.emptyString.rawValue,
            PlacedOrderParam.state: state ?? DefaultValue.emptyString.rawValue,
            PlacedOrderParam.city: city ?? DefaultValue.emptyString.rawValue,
            PlacedOrderParam.zipcode:zipcode ?? DefaultValue.emptyString.rawValue,
            PlacedOrderParam.address: address ?? DefaultValue.emptyString.rawValue
        ]
        
        if let addressId = billingAddressId{
            billingAddressParam[PlacedOrderParam.billingAddressId] = addressId
        }else{
            billingAddressParam[PlacedOrderParam.billingAddressId] = ""
            
        }
        
        let param: [String: Any] = [
            PlacedOrderParam.userId : userID ?? 0,
            PlacedOrderParam.cartItems: cartItems ?? 0,
            PlacedOrderParam.totalPrice : totalPrice ?? 0,
            PlacedOrderParam.stripeToken: stripeToken ?? DefaultValue.emptyString.rawValue ,
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

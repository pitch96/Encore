//
//  CartViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 11/01/23.
//

import Foundation


class CartViewModel : NSObject{
    // MARK: Create function for call Check out API--
    func callCheckOutApi(completition: @escaping(CartModelData, Bool) -> Void){
        Webservice.service(api: .checkout,service: .get) { (model: CartModelData , data, json) in
            if model.statusCode == 200{
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
    // MARK: Create function for call update Cart API--
    func callUpdateCartApi(userID: Int, ticketID: Int, quantity: Int, complition: @escaping(CartModelData?, Bool)->Void){
        let param: [String: Any] = [
            AddToCartParam.userID : userID,
            AddToCartParam.ticketID : ticketID,
            AddToCartParam.quantity : quantity
            
        ]
        Webservice.service(api: .updateCart, param: param,service: .post) { (model: CartModelData, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
    // MARK: Create function for call Delete Cart API--
    func callDeleteCartApi(id: Int, complition: @escaping(DeleteCart?, Bool)->Void){
        Webservice.service(api: .deleteCartItem, urlAppendId: "/\(id)",service: .get) { (model: DeleteCart, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
    // MARK: Create function for call Place Order API--
    func callPlacedOrderApi(userID: Int?,totalPrice: Int?,billingAddressId: Int?,fullName: String?,phoneNumber: String?,email:String?,state: String?, city: String?,zipcode: String?, address:String?,stripeToken: String?,cartItems:Int?, complition: @escaping(PlacedOrder?, Bool)->Void){
        
        var billingAddressParam: [String: Any] = [
            
            PlacedOrderParam.fullName : fullName ?? DefaultValue.emptyString.rawValue,
            PlacedOrderParam.phoneNumber: phoneNumber ?? DefaultValue.emptyString.rawValue,
           // PlacedOrderParam.billingAddressId : billingAddressId ?? 0,
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

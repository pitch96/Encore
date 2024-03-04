//
//  MyOrderViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 29/12/22.
//

import Foundation
import UIKit

class MyOrderViewModel : Codable{
    // MARK: Create function for call Order Detail API--
    func callOrderDetailApi(completition: @escaping(OrderModel?, Bool) -> Void){
        Webservice.service(api: .OrderDetail,service: .get) { (model: OrderModel , data, json) in
            if model.statusCode == 200{
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
   
    
}

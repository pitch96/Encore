//
//  SubscriberViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 03/03/23.
//

import Foundation
class SubscriberListViewModel : Codable{
    // MARK: Create function for call get subscriber user API--
    func callSubscriberListApi(completition: @escaping(SubscriberListModel, Bool) -> Void){
        Webservice.service(api: .GetSubscriberList,service: .get) { (model: SubscriberListModel , data, json) in
            if model.statusCode == 200{
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
}

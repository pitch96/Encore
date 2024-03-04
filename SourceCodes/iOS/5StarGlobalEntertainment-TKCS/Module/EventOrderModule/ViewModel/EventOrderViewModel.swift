//
//  EventOrderViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 03/04/23.
//

import Foundation
class EventOrderViewModel: Codable{
    
    var name = String()
    // MARK: - call Expired Event Api
    func callExpiredEventApi(completition: @escaping(EventOrderModel, Bool) -> Void){
        Webservice.service(api: .ExpiredEvent,service: .get) { (model: EventOrderModel , data, json) in
            if model.success ?? false{
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
    // MARK: - call Running Event Api
    func callRunningEventApi(completition: @escaping(RunningDataModel, Bool) -> Void){
        Webservice.service(api: .RunningEvent,service: .get) { (model: RunningDataModel , data, json) in
            if model.success ?? false{
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
}

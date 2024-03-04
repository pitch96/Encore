//
//  ManageEventViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 07/02/23.
//

import Foundation
class ManageEventViewModel: NSObject{
    
    var id = Int()
    // MARK: Create function for call manage event API--
    func calllManageEventApi(completition: @escaping(ManageEventModel, Bool) -> Void){
        Webservice.service(api: .ManageEvents,service: .get) { (model: ManageEventModel , data, json) in
            if model.success ?? false{
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
    // MARK: Create function for call get ALL event API--
    func calllAllEventApi(completition: @escaping(GetAllModel, Bool) -> Void){
        Webservice.service(api: .GetAllEvent,service: .get) { (model: GetAllModel , data, json) in
            if model.success ?? false{
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
    // MARK: Create function for call delete event API--
    func callDeleteEventApi(id: Int, complition: @escaping(DeleteEventModel?, Bool)->Void){

        Webservice.service(api: .CreateEvent, urlAppendId:"/\(id)",service: .delete) { (model: DeleteEventModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
    // MARK: Create function for call change event status API--
    func callGetStatusApi(eventId: Int,status:Int, complition: @escaping(StatusChangeModel?, Bool)->Void){
        let st = "status"
        let urlAppendId = "/\(eventId)/\(st)/\(status)"
        Webservice.service(api: .CreateEvent, urlAppendId: urlAppendId, service: .get) { (model: StatusChangeModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
    func callPopularEventApi(eventId: Int,status:Int, complition: @escaping(PopularEventStatusModel?, Bool)->Void){
        let urlAppendId = "/\(eventId)/\(status)"
        Webservice.service(api: .PopularEvent, urlAppendId: urlAppendId, service: .get) { (model: PopularEventStatusModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
}

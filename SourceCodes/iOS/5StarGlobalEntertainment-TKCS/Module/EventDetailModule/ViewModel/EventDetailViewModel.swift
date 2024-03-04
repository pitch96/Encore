//
//  EventDetailViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 09/02/23.
//

import Foundation
class EventDetailViewModel : NSObject{
    
    var id = Int()
    var freeId = Int()
    // MARK: Create function for get event by Id--
    func callGetEventDetailsApi(id: Int?, complition: @escaping(EventDetailModel?, Bool)->Void){
        Webservice.service(api: .GetEventDetails, urlAppendId: "/\(id ?? 0)", service: .get) { (model: EventDetailModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
    // MARK: Create function for status API--
    func callStatusApi(eventId: Int,status:Int, complition: @escaping(StatusChangeModel?, Bool)->Void){
        
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
    // MARK: Create function for Refer Link api--
    func callReferLinkApi(eventID: Int?, complition: @escaping(ReferLinkModel?, Bool)->Void){
        Webservice.service(api: .ReferLink, urlAppendId: "/\(eventID ?? 0)", service: .get) { (model: ReferLinkModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
}

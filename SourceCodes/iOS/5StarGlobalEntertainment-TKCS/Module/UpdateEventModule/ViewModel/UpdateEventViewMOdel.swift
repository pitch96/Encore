//
//  UpdateEventViewMOdel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 08/02/23.
//

import Foundation
class UpdateEventViewModel : NSObject{
    // MARK: Variable Initializer--
    var updateEventData : UpdateEventModel?
    var media = [Media]()
    var id = Int()
    // MARK: Create function for call create event API--
    func callGetEventApi(id: Int, complition: @escaping(GetEventModel?, Bool)->Void){
        Webservice.service(api: .CreateEvent, urlAppendId: "/\(id)", service: .get) { (model: GetEventModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
    // MARK: Create function for call get event category list API--
    func callgetEventCategoryListApi(completition: @escaping(ManageCategoryModel, Bool) -> Void){
        Webservice.service(api: .ManageCategory,service: .get) { (model: ManageCategoryModel , data, json) in
            if model.statusCode == 200{
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
    // MARK: Create function for call update event list API--
    func callUpdateEventApi(eventId: Int?, categoryId: Int?, eventTitle: String, organizer: String, venue: String, address: String, city: String, zipcode: String, startDate: String, endDate: String, startTime: String, endTime: String, description: String, image: String, file: [Media],complition: @escaping(UpdateEventModel?, Bool)->Void){
        let params: [String: Any] = [
            UpdateEventParam.category_id : "\(categoryId ?? 0)",
            UpdateEventParam.event_title : eventTitle,
            UpdateEventParam.organizer : organizer,
            UpdateEventParam.venue : venue,
            UpdateEventParam.address : address,
            UpdateEventParam.city: city,
            UpdateEventParam.zipcode: zipcode,
            UpdateEventParam.start_date: startDate,
            UpdateEventParam.end_date: endDate,
            UpdateEventParam.start_time: startTime,
            UpdateEventParam.end_time: endTime,
            UpdateEventParam.description: description,
            "_method": "PUT",
            UpdateEventParam.image: image
            ]
            debugPrint("params===",params)
        Webservice.service(api: .CreateEvent, urlAppendId: "/\(id)",param: params, service: .post, file: file) { (model: UpdateEventModel, data, json) in
            if model.statusCode == 200{
                self.updateEventData = model
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
}

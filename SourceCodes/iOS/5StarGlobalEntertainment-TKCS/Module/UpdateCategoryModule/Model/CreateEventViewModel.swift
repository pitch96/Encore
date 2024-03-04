//
//  CreateEventViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 07/02/23.
//

import Foundation

class CreateEventViewModel : NSObject{
    // MARK: Variable Initializer--
    var eventData : CreateEventModel?
    var media = [Media]()
    // MARK: Create function For call Create Event API--
    func callCreateEventApi(id: Int?, eventTitle: String, organizer: String, venue: String, address: String, city: String, zipcode: String, startDate: String, endDate: String, startTime: String, endTime: String, description: String, image: String, file: [Media],complition: @escaping(CreateEventModel?, Bool)->Void){
        let param: [String: Any] = [
            CreateEventParam.category_id : "\(id ?? 0)",
            CreateEventParam.event_title : eventTitle,
            CreateEventParam.organizer : organizer,
            CreateEventParam.venue : venue,
            CreateEventParam.address: address,
            CreateEventParam.city: city,
            CreateEventParam.zipcode: zipcode,
            CreateEventParam.start_date: startDate,
            CreateEventParam.end_date: endDate,
            CreateEventParam.start_time: startTime,
            CreateEventParam.end_time: endTime,
            CreateEventParam.description: description,
            CreateEventParam.image : image
            
            ]
        debugPrint(param)
        Webservice.service(api: .CreateEvent, param: param,service: .post, file: file) { (model: CreateEventModel, data, json) in
            if model.statusCode == 200{
                self.eventData = model
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
    // MARK: Create function For Manage Category to get category API--
    func callgetCategoryListApi(completition: @escaping(ManageCategoryModel, Bool) -> Void){
        Webservice.service(api: .ManageCategory,service: .get) { (model: ManageCategoryModel , data, json) in
            if model.statusCode == 200{
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
}

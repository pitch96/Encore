//
//  EventCategoryListViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 15/04/23.
//

import Foundation

class EventCategoryListViewModel: Codable{
    // MARK: - Create function for All Event list
    func CallEventCategoryListApi(completition: @escaping(EventListModel, Bool) -> Void){
        Webservice.service(api: .filterEvent,service: .get) { (model: EventListModel , data, json) in
            if model.success ?? false{
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
    // MARK: - Create function for category list
    func CallCategoryListApi(completition: @escaping(CategoryLisModel, Bool) -> Void){
        Webservice.service(api: .catagories,service: .get) { (model: CategoryLisModel , data, json) in
            if model.success ?? false{
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
}

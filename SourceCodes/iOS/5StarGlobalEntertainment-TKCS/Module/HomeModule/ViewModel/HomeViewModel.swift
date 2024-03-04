//
//  FSGHomeViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 25/11/22.
//

import Foundation
import UIKit
class HomeViewModel{
    // MARK: Create function for call Home Page API--
    func CallHomeApi(completition: @escaping(HomePage, Bool) -> Void){
        Webservice.service(api: .homePage,service: .get) { (model: HomePage , data, json) in
            if model.success ?? false{
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
    // MARK: Create function For call Logout API--
    func CallLogoutApi(token:String, completition: @escaping(LogoutModel, Bool) -> Void){
        let params = ["token":token] as [String:Any]
        Webservice.service(api: .logout,param: params,service: .get) { (model: LogoutModel , data, json) in
            if model.success {
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
    // MARK: Create function For call Subscribe user api--
    func CallSubscribeApi(email:String, completition: @escaping(SubscribeModel?, Bool) -> Void){
        let params = [
            "email" : email
        ] 
        Webservice.service(api: .Subscribe,param: params,service: .post) { (model: SubscribeModel? , data, json) in
            if model?.statusCode == 200 {
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
    
    
    // MARK: search event by categoryId--
    func callSearchCategoryApi(id: Int, complition: @escaping(CategorySearch?, Bool)->Void){
        Webservice.service(api: .catagoryEventById, urlAppendId:"\(id)",service: .get) { (model: CategorySearch, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
}

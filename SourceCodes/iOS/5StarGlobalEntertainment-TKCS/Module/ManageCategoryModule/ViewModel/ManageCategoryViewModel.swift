//
//  ManageCategoryViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 06/02/23.
//

import Foundation
class ManageCategoryViewModel : Codable{
    // MARK: Create function for call manage category API--
    func callManageCategoryApi(completition: @escaping(ManageCategoryModel, Bool) -> Void){
        Webservice.service(api: .ManageCategory,service: .get) { (model: ManageCategoryModel , data, json) in
            if model.statusCode == 200{
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
    // MARK: Create function for call delete category API--
    func callDeleteCategoryApi(id: Int, complition: @escaping(ManageCategoryModel?, Bool)->Void){

        Webservice.service(api: .addCategory, urlAppendId:"/\(id)",service: .delete) { (model: ManageCategoryModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
}

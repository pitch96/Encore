//
//  UpdateCategoryViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 06/02/23.
//

import Foundation
class UpdateCategoryViewModel : NSObject{
    // MARK: Variable Initializer--
    var updateCategoryData : UpdateCategoryModel?
    var id = Int()
    // MARK: Create function for call add category API--
    func callGetCategoryApi(id: Int, complition: @escaping(UpdateCategoryModel?, Bool)->Void){
        Webservice.service(api: .addCategory, urlAppendId: "/\(id)", service: .get) { (model: UpdateCategoryModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
    // MARK: Create function for call update category API--
    func callUpdateCategoryApi(id: Int, fName: String, completion: @escaping(UpdateCategoryModel?, Bool)-> Void){
        let paramData : [String: Any] = [
            UpdateCategoryParam.name: fName
        ]
        Webservice.service(api: .addCategory, urlAppendId: "/\(id)", param: paramData,service: .put) { (model: UpdateCategoryModel , data, json) in
            if model.statusCode == 200{
                self.updateCategoryData = model
                completion(model, true)
            }else{
                completion(model, false)
            }

        }
    }
}

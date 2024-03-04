//
//  AddCategoryViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 03/02/23.
//

import Foundation
class AddCategoryViewModel : NSObject{
    // MARK: Create function for call Add category API--
    func callAddCategoryApi(fName:String,complition: @escaping(AddCategoryModel?, Bool)->Void){
        let param: [String: Any] = [
            AddCategoryParam.name: fName
        ]
        Webservice.service(api: .addCategory, param: param,service: .post) { (model: AddCategoryModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
}

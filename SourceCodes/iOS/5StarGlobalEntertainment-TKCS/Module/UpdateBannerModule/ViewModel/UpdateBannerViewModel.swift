//
//  UpdateBannerViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 09/03/23.
//

import Foundation

class UpdateBannerViewModel : NSObject{
    // MARK: Variable Initializer--
    var id = Int()
    var media = [Media]()
    var updateBannerData : UpdateBannerModel?
    // MARK: Create function for get Banner Data Api --
    func callBannerApi(id: Int, complition: @escaping(GetBannerData?, Bool)->Void){
        // MARK: Web-Service method--
        Webservice.service(api: .GetBannerData, urlAppendId: "/\(id)", service: .get) { (model: GetBannerData, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }}
    }
    // MARK: Create function for update Banner Data Api --
    func callUpdateBannerApi(description: String?, image: String?, file: [Media],complition: @escaping(UpdateBannerModel?, Bool)->Void){
        let params: [String: Any] = [
           "description" : description ?? DefaultValue.emptyString.rawValue,
            DefaultValue.BannerImage.rawValue: image ?? DefaultValue.emptyString.rawValue
            ]
        // MARK: Web-Service method--
        

        Webservice.service(api: .UpdateBanner,urlAppendId: "/\(id)",param: params, service: .post,file: file) { (model: UpdateBannerModel, data, json) in
            if model.statusCode == 200{
                self.updateBannerData = model
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
   
}

//
//  ManageBannerViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 02/03/23.
//

import Foundation

class ManageBannerViewModel : Codable{
    // MARK: Create function for calling banner images API--
    func callBannerImagesApi(completition: @escaping(ManageBannerModel, Bool) -> Void){
        Webservice.service(api: .BannerImages,service: .get) { (model: ManageBannerModel , data, json) in
            if model.statusCode == 200{
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
    // MARK: Create function for calling Delete banner images API--
    func callDeleteBannerApi(id: Int, complition: @escaping(DeleteBannerModel?, Bool)->Void){

        Webservice.service(api: .DeleteBanner, urlAppendId:"/\(id)",service: .get) { (model: DeleteBannerModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
    // MARK: Create function for calling change banner images status API--
    func callBannerStatusApi(bannerId: Int,status:Int, complition: @escaping(BannerStatusModel?, Bool)->Void){
        
        let st = "status"

        let urlAppendId = "/\(st)/\(bannerId)/\(status)"

        Webservice.service(api: .changeBanner, urlAppendId: urlAppendId, service: .get) { (model: BannerStatusModel, data, json) in

            if model.statusCode == 200{
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
}

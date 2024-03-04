//
//  AddBannerViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 03/03/23.
//

import Foundation
import UIKit


class SaveBannerViewModel : NSObject{
    // MARK: Variable initializer--
    var bannerData : SaveBannerModel?
    var mediaData = [Media]()
    var bannerDesp = [[String: String]]()
    var imagepath = [String]()
    var indexPath = Int()
    var cell = AddBannerTableViewCell()
    
   // MARK: create function for calling add banner api--
    func callSaveBannerApi(request: [AddedBannerDataList], complition: @escaping(SaveBannerModel?, Bool) -> Void) {
        for params in request {
            if let media = Media(withImage: params.bannerImage ?? UIImage(), forKey:DefaultValue.imageBanner.rawValue){
                mediaData.append(media)
            }
            if let discription = params.description {
                let discriptionDict =  [DefaultValue.arrDescription.rawValue: discription]
                bannerDesp.append(discriptionDict)
            }
        }
       // MARK: Webservice method call--
        Webservice.service(api: .AddBanner, param: bannerDesp, service: .post, file: mediaData) { (model: SaveBannerModel, data, json) in
            if model.statusCode == 200{
                complition(model, true)
            } else {
                complition(model, false)
            }
        }
    }
}

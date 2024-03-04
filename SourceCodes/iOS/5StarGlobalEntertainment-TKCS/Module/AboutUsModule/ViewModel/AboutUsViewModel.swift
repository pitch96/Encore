//
//  AboutUsViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 24/01/23.
//

import Foundation

class AboutUsViewModel: NSObject{
    // MARK: Create function for call ABoutUs API--
    func callAboutUsApi(completition: @escaping(AboutUsModel, Bool) -> Void){
        Webservice.service(api: .AboutUs,service: .get) { (model: AboutUsModel , data, json) in
            if model.statusCode == 200{
                completition(model,true)
            }else{
                completition(model,false)
            }
        }
    }
}

//
//  GuestUserViewModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 11/04/23.
//

import Foundation
class GuestUserViewModel: Codable{
    // MARK: - Variable initializer
    var id = Int()
    var billingList = [BillingData]()
    // MARK: - Create function for guest user APi
    func callGuestUserApi(id: Int, complition: @escaping(GuestListModel?, Bool)->Void){
        Webservice.service(api: .GuestList, urlAppendId:"/\(id)",service: .get) {[weak self] (model: GuestListModel, data, json) in
            if model.statusCode == 200{
                //self?.decodeData(guestData: model.data ?? [])
                complition(model, true)
            }else{
                complition(model, false)
            }
        }
    }
    
    // method to decode billing data and convert into JSON
    /// - Parameter guestData: Guest Data List
    func decodeData(guestData: [GuestListDetail]) {
        if guestData.count > 0 {
             guestData.forEach { data in
                 let data =  data.billingAddress?.data(using: .utf8)
                do {
                    let modelData = try JSONDecoder().decode(BillingData.self, from: data!)
                    billingList.append(modelData)
                    debugPrint("billing data is: ",billingList, modelData)
                } catch {
                    debugPrint("Mismatch error")
                }
            }
            
        }
    }
}

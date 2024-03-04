//
//  PromoterPaymentModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 13/04/23.
//

import Foundation
// MARK: - Promoter Payment model
struct EventLivePaymentModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message: String?
    var data: PaymentModelDetails?
}

// MARK: - PaymentModelDetails
struct PaymentModelDetails: Codable {
    var status, message: String?
}

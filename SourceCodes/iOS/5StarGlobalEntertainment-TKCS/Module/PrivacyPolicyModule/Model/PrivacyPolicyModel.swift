//
//  PrivacyPolicyModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 25/01/23.
//

import Foundation
// MARK: - Privacy Policy Model
struct PrivacyPolicyModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message, data: String?
}
